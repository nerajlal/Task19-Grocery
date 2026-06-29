@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="container-fluid" style="max-width: 1200px; padding-bottom: 2.5rem;">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.products') }}" class="text-secondary text-decoration-none">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="h3 fw-bold text-dark mb-0">{{ $product->title }}</h1>
        <span class="badge bg-success bg-opacity-10 text-success rounded-pill fw-medium text-uppercase small">Active</span>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="row g-4">
        @csrf
        @method('PUT')
        <!-- Left Column -->
        <div class="col-12 col-lg-8">
            
            <!-- Basic Info -->
            <div class="card border shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium text-secondary small mb-1">Title</label>
                        <input type="text" name="title" value="{{ old('title', $product->title) }}" class="form-control shadow-sm" required>
                    </div>
                    <div>
                        <label class="form-label fw-medium text-secondary small mb-1">Description</label>
                        <textarea name="description" rows="6" class="form-control shadow-sm">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Media -->
            <div class="card border shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h6 fw-semibold text-secondary mb-0">Media</h2>
                        <!-- <button type="button" id="toggleUrlBtn" class="btn btn-link btn-sm text-decoration-none p-0" onclick="toggleUrlInput()">Add from URL</button> -->
                    </div>
                    
                    <!-- URL Input Section - HIDDEN -->
                    <!--
                    <div id="urlInputContainer" class="d-none mb-3 p-3 bg-light rounded border">
                        <label class="form-label fw-medium text-secondary extra-small mb-1">Image or Video URL</label>
                        <div class="input-group input-group-sm">
                            <input type="text" id="mediaUrl" class="form-control" placeholder="https://example.com/image.jpg">
                            <button type="button" onclick="addMediaFromUrl()" class="btn btn-white border text-secondary">Add</button>
                        </div>
                        <p class="text-muted extra-small mt-1 mb-0">Supports types: .jpg, .png, .gif, .mp4, .mov</p>
                    </div>
                    -->

                    <input type="file" id="media_upload" name="media[]" multiple accept=".webp" class="d-none" onchange="handleFileSelect(event)">
                    
                    <!-- Preview Grid -->
                    <div id="media_preview_grid" class="row g-3 mb-3 {{ $product->images->isEmpty() ? 'd-none' : '' }}">
                         <!-- Existing Images -->
                         @foreach($product->images as $image)
                             <div class="col-6 col-md-3 existing-image" data-id="{{ $image->id }}" style="cursor: move;">
                                 <input type="hidden" name="media_order[]" value="{{ $image->id }}">
                                 <div class="ratio ratio-1x1 bg-light rounded border overflow-hidden position-relative group-hover-container d-flex align-items-center justify-content-center">
                                     <img src="{{ asset('storage/' . $image->path) }}" class="w-100 h-100 object-fit-cover">
                                     <button type="button" onclick="markImageForDeletion(this, {{ $image->id }})" class="btn btn-white btn-sm rounded-circle shadow-sm position-absolute top-0 end-0 m-1 opacity-0 group-hover-visible transition-opacity text-danger p-0 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                        <i class="fas fa-trash extra-small"></i>
                                    </button>
                                 </div>
                             </div>
                         @endforeach
                    </div>

                    <div id="media_dropzone" class="border opacity-50 border-2 border-dashed rounded py-5 text-center bg-light bg-opacity-25 cursor-pointer hover-bg-light transition-base" onclick="document.getElementById('media_upload').click()">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-image text-secondary opacity-50 fs-2 mb-2"></i>
                            <span class="text-secondary small fw-medium mb-1">Add images</span>
                            <p class="text-muted extra-small mb-0">Accepts .webp images only</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Container for deleted image IDs -->
            <div id="deleted_images_container"></div>

            <!-- SortableJS -->
            <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

            <script>
                // Initialize Sortable
                document.addEventListener('DOMContentLoaded', function() {
                    var el = document.getElementById('media_preview_grid');
                    var sortable = Sortable.create(el, {
                        animation: 150,
                        handle: '.existing-image', // Allow dragging by the whole item
                        draggable: '.existing-image', // Only existing images are draggable for now
                        onEnd: function (evt) {
                            // Optional: logic to handle drop event if needed
                        }
                    });
                });

                /*
                function toggleUrlInput() {
                    document.getElementById('urlInputContainer').classList.toggle('d-none');
                }
                */

                function handleFileSelect(event) {
                    const files = event.target.files;
                    const previewGrid = document.getElementById('media_preview_grid');
                    
                    if (files.length > 0) {
                         previewGrid.classList.remove('d-none');
                    }
                    
                    // Max 5 Images Validation
                    const existingCount = document.querySelectorAll('.existing-image').length;
                    const deletedCount = document.querySelectorAll('input[name="deleted_images[]"]').length;
                    const newCount = files.length;
                    
                    if ((existingCount - deletedCount + newCount) > 5) {
                        alert(`You can only have a maximum of 5 images. You currently have ${existingCount}, are deleting ${deletedCount}, and trying to add ${newCount}.`);
                        event.target.value = ''; // Clear input
                        return; // Stop processing
                    }

                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        
                        if (!file.type.startsWith('image/')) continue;

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            createPreviewItem(e.target.result, 'image');
                        };
                        reader.readAsDataURL(file);
                    }
                }

                /*
                function addMediaFromUrl() {
                   // ...
                }
                */

                function createPreviewItem(src, type) {
                    const previewGrid = document.getElementById('media_preview_grid');
                    const col = document.createElement('div');
                    col.className = 'col-6 col-md-3'; // Note: New items aren't draggable yet
                    
                    const div = document.createElement('div');
                    div.className = 'ratio ratio-1x1 bg-dark rounded border overflow-hidden position-relative group-hover-container';
                    
                    let content = '';
                    if (type === 'video') {
                        content = `<video src="${src}" class="w-100 h-100 object-fit-cover opacity-75"></video><i class="fas fa-play position-absolute top-50 start-50 translate-middle text-white fs-3 opacity-75"></i>`;
                    } else {
                        content = `<img src="${src}" class="w-100 h-100 object-fit-cover">`;
                    }

                    div.innerHTML = `
                        ${content}
                        <button type="button" onclick="this.closest('.col-6').remove()" class="btn btn-white btn-sm rounded-circle shadow-sm position-absolute top-0 end-0 m-1 opacity-0 group-hover-visible transition-opacity text-danger p-0 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                            <i class="fas fa-trash extra-small"></i>
                        </button>
                    `;
                    col.appendChild(div);
                    // Append new items to the grid. Note: They won't be in the media_order array until saved and reloaded.
                    previewGrid.appendChild(col);
                }

                function markImageForDeletion(btn, id) {
                    btn.closest('.col-6').remove();
                    const container = document.getElementById('deleted_images_container');
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'deleted_images[]';
                    input.value = id;
                    container.appendChild(input);
                }
            </script>

            <!-- Variants Section -->
            <div class="card border shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h6 fw-semibold text-secondary mb-0">Product Variants (Wholesale & Retail)</h2>
                        <button type="button" class="btn btn-outline-success btn-sm fw-medium" onclick="addVariantRow()">+ Add Variant</button>
                    </div>
                    <div id="variants-container" class="vstack gap-3">
                        @foreach($product->variants as $variant)
                        <div class="border rounded p-3 bg-light bg-opacity-50 variant-row">
                            <div class="row g-2 align-items-end">
                                <div class="col-12 col-md-3">
                                    <label class="form-label extra-small fw-medium text-muted mb-1">Variant Name (e.g. 1kg, Pack of 10)</label>
                                    <input type="text" class="form-control form-control-sm shadow-sm variant-size-input" value="{{ $variant->size }}" placeholder="e.g. 1kg" required oninput="updateRowInputNames(this.closest('.variant-row'))">
                                    <input type="hidden" class="variant-enabled-input" name="variant_data[{{ $variant->size }}][enabled]" value="1">
                                </div>
                                <div class="col-4 col-md-3">
                                    <label class="form-label extra-small fw-medium text-muted mb-1">Stock</label>
                                    <input type="number" class="form-control form-control-sm shadow-sm variant-stock-input" name="variant_data[{{ $variant->size }}][stock]" value="{{ $variant->stock }}" placeholder="0">
                                </div>
                                <div class="col-4 col-md-2">
                                    <label class="form-label extra-small fw-medium text-muted mb-1">Price (₹)</label>
                                    <input type="text" class="form-control form-control-sm shadow-sm variant-price-input" name="variant_data[{{ $variant->size }}][price]" value="{{ $variant->price }}" placeholder="0.00" required>
                                </div>
                                <div class="col-4 col-md-2">
                                    <label class="form-label extra-small fw-medium text-muted mb-1">Compare Price (₹)</label>
                                    <input type="text" class="form-control form-control-sm shadow-sm variant-compare-input" name="variant_data[{{ $variant->size }}][compare_at_price]" value="{{ $variant->compare_at_price }}" placeholder="0.00">
                                </div>
                                <div class="col-12 col-md-2 text-end">
                                    <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeVariantRow(this)">Remove</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <script>
                function updateRowInputNames(rowElement) {
                    const sizeInput = rowElement.querySelector('.variant-size-input');
                    const sizeVal = sizeInput.value.trim();
                    const cleanSize = sizeVal ? sizeVal : 'unnamed_' + Math.random().toString(36).substring(7);

                    const enabledInput = rowElement.querySelector('.variant-enabled-input');
                    const stockInput = rowElement.querySelector('.variant-stock-input');
                    const priceInput = rowElement.querySelector('.variant-price-input');
                    const compareInput = rowElement.querySelector('.variant-compare-input');

                    enabledInput.name = `variant_data[${cleanSize}][enabled]`;
                    stockInput.name = `variant_data[${cleanSize}][stock]`;
                    priceInput.name = `variant_data[${cleanSize}][price]`;
                    compareInput.name = `variant_data[${cleanSize}][compare_at_price]`;
                }

                function addVariantRow() {
                    const container = document.getElementById('variants-container');
                    const row = document.createElement('div');
                    row.className = 'border rounded p-3 bg-light bg-opacity-50 variant-row';
                    row.innerHTML = `
                        <div class="row g-2 align-items-end">
                            <div class="col-12 col-md-3">
                                <label class="form-label extra-small fw-medium text-muted mb-1">Variant Name (e.g. 1kg, Pack of 10)</label>
                                <input type="text" class="form-control form-control-sm shadow-sm variant-size-input" placeholder="e.g. 1kg" required oninput="updateRowInputNames(this.closest('.variant-row'))">
                                <input type="hidden" class="variant-enabled-input" value="1">
                            </div>
                            <div class="col-4 col-md-3">
                                <label class="form-label extra-small fw-medium text-muted mb-1">Stock</label>
                                <input type="number" class="form-control form-control-sm shadow-sm variant-stock-input" placeholder="0">
                            </div>
                            <div class="col-4 col-md-2">
                                <label class="form-label extra-small fw-medium text-muted mb-1">Price (₹)</label>
                                <input type="text" class="form-control form-control-sm shadow-sm variant-price-input" placeholder="0.00" required>
                            </div>
                            <div class="col-4 col-md-2">
                                <label class="form-label extra-small fw-medium text-muted mb-1">Compare Price (₹)</label>
                                <input type="text" class="form-control form-control-sm shadow-sm variant-compare-input" placeholder="0.00">
                            </div>
                            <div class="col-12 col-md-2 text-end">
                                <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeVariantRow(this)">Remove</button>
                            </div>
                        </div>
                    `;
                    container.appendChild(row);
                    updateRowInputNames(row);
                }

                function removeVariantRow(button) {
                    const row = button.closest('.variant-row');
                    const container = document.getElementById('variants-container');
                    if (container.children.length > 1) {
                        row.remove();
                    } else {
                        alert('You must have at least one variant.');
                    }
                }

                document.addEventListener('DOMContentLoaded', function() {
                    const container = document.getElementById('variants-container');
                    if (container && container.children.length === 0) {
                        addVariantRow();
                    }
                });
            </script>          </div>

        </div>

        <!-- Right Column -->
        <div class="col-12 col-lg-4">
            
            <!-- Status -->
            <div class="card border shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h6 fw-semibold text-secondary mb-3">Product Status</h2>
                    <select name="status" class="form-select shadow-sm">
                        <option value="active" @selected(old('status', $product->status) == 'active')>Active</option>
                        <option value="draft" @selected(old('status', $product->status) == 'draft')>Draft</option>
                    </select>
                </div>
            </div>

            <!-- Organization -->
            <div class="card border shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h6 fw-semibold text-secondary mb-3">Product Organization</h2>
                    <div class="vstack gap-3">
                        <div>
                            <label class="form-label fw-medium text-secondary small mb-1">Product type</label>
                            <input type="text" name="type" value="{{ old('type', $product->type) }}" class="form-control shadow-sm">
                        </div>
                        <div>
                            <label class="form-label fw-medium text-secondary small mb-1">Collections</label>
                            <select name="collection_id" class="form-select shadow-sm">
                                <option value="">Select a collection</option>
                                @foreach($collections as $collection)
                                    <option value="{{ $collection->id }}" @selected(old('collection_id', $product->collection_id) == $collection->id)>{{ $collection->name }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                </div>
            </div>



        </div>
        
        <div class="col-12 d-flex justify-content-end gap-2 border-top pt-3">
            <button type="button" class="btn btn-danger-soft text-danger me-auto" onclick="if(confirm('Delete this product?')) document.getElementById('delete-product-form').submit()">Delete product</button>
            <button type="button" class="btn btn-white border shadow-sm text-secondary">Discard</button>
            <button type="submit" class="btn btn-success shadow-sm">Save</button>
        </div>
    </form>
    
    <form id="delete-product-form" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>
<style>
    .group-hover-visible { visibility: hidden; }
    .group-hover-container:hover .group-hover-visible { visibility: visible; opacity: 1 !important; }
    .extra-small { font-size: 0.75rem; }
    .hover-bg-light:hover { background-color: var(--bs-light) !important; }
    .cursor-pointer { cursor: pointer; }
    .btn-danger-soft { background-color: rgba(220, 53, 69, 0.1); border-color: transparent; }
    .btn-danger-soft:hover { background-color: rgba(220, 53, 69, 0.2); }
</style>@endsection
