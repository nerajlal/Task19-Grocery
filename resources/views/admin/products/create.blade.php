@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
<div class="container-fluid" style="max-width: 1200px; padding-bottom: 2.5rem;">
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.products') }}" class="text-secondary text-decoration-none">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="h3 fw-bold text-dark mb-0">Add product</h1>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="row g-4">
        @csrf
        <!-- Left Column -->
        <div class="col-12 col-lg-8">
            
            <!-- Basic Info -->
            <div class="card border shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium text-secondary small mb-1">Title</label>
                        <input type="text" name="title" class="form-control shadow-sm" placeholder="e.g. Fresh Organic Apples" required>
                    </div>
                    <div>
                        <label class="form-label fw-medium text-secondary small mb-1">Description</label>
                        <textarea name="description" rows="6" class="form-control shadow-sm"></textarea>
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
                    <div id="media_preview_grid" class="row g-3 mb-3 d-none"></div>

                    <div id="media_dropzone" class="border opacity-50 border-2 border-dashed rounded py-5 text-center bg-light bg-opacity-25 cursor-pointer hover-bg-light transition-base" onclick="document.getElementById('media_upload').click()">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fas fa-image text-secondary opacity-50 fs-2 mb-2"></i>
                            <span class="text-secondary small fw-medium mb-1">Add images</span>
                            <p class="text-muted extra-small mb-0">Accepts .webp images only</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SortableJS -->
            <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

            <script>
                // Global DataTransfer to manage selected files
                let dt = new DataTransfer();

                document.addEventListener('DOMContentLoaded', function() {
                    var el = document.getElementById('media_preview_grid');
                    // Initialize Sortable
                    var sortable = Sortable.create(el, {
                        animation: 150,
                        onEnd: function (evt) {
                            updateFilesFromDOM();
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
                    if (files.length > 5) {
                        alert('You can only upload a maximum of 5 images.');
                        event.target.value = ''; // Clear input
                        return;
                    }

                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        
                        // Enforce WebP only
                        if (file.type !== 'image/webp') {
                            alert('Only WebP images are allowed: ' + file.name);
                            continue;
                        }

                        // Add to DataTransfer
                        dt.items.add(file);

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            createPreviewItem(e.target.result, 'image', file);
                        };
                        reader.readAsDataURL(file);
                    }
                    
                    // Sync input files
                    document.getElementById('media_upload').files = dt.files;
                }

                function updateFilesFromDOM() {
                    const newDt = new DataTransfer();
                    const previewItems = document.querySelectorAll('.preview-item');
                    
                    previewItems.forEach(item => {
                        // We attached the file object to the DOM element in createPreviewItem
                        if (item.fileRef) {
                            newDt.items.add(item.fileRef);
                        }
                    });
                    
                    dt = newDt;
                    document.getElementById('media_upload').files = dt.files;
                }

                /*
                function addMediaFromUrl() {
                   // ...
                }
                */

                function createPreviewItem(src, type, fileObj) {
                    const previewGrid = document.getElementById('media_preview_grid');
                    const col = document.createElement('div');
                    col.className = 'col-6 col-md-3 preview-item';
                    col.style.cursor = 'move';
                    
                    // Store file reference for reordering
                    col.fileRef = fileObj;
                    
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
                        <button type="button" onclick="removeFile(this)" class="btn btn-white btn-sm rounded-circle shadow-sm position-absolute top-0 end-0 m-1 opacity-0 group-hover-visible transition-opacity text-danger p-0 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                            <i class="fas fa-trash extra-small"></i>
                        </button>
                    `;
                    col.appendChild(div);
                    previewGrid.appendChild(col);
                }

                function removeFile(btn) {
                    btn.closest('.preview-item').remove();
                    updateFilesFromDOM();
                    
                    // Hide grid if empty
                     const previewGrid = document.getElementById('media_preview_grid');
                     if (previewGrid.children.length === 0) {
                         previewGrid.classList.add('d-none');
                     }
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
                        <!-- Dynamic Variant Rows Will Be Appended Here -->
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
            </script>

        </div>

        <!-- Right Column -->
        <div class="col-12 col-lg-4">
            
            <!-- Status -->
            <div class="card border shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h6 fw-semibold text-secondary mb-3">Product Status</h2>
                    <select name="status" class="form-select shadow-sm">
                        <option value="active" selected>Active</option>
                        <option value="draft">Draft</option>
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
                            <input type="text" name="type" class="form-control shadow-sm" placeholder="e.g. Fruits, Beverages" value="Grocery">
                        </div>
                        <div>
                            <label class="form-label fw-medium text-secondary small mb-1">Collections</label>
                            <select name="collection_id" class="form-select shadow-sm">
                                <option value="">Select a collection</option>
                                @foreach($collections as $collection)
                                    <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                </div>
            </div>



        </div>
        
        <div class="col-12 d-flex justify-content-end gap-2 border-top pt-3">
            <button type="button" class="btn btn-white border shadow-sm text-secondary">Discard</button>
            <button type="submit" class="btn btn-success shadow-sm">Save</button>
        </div>
    </form>
</div>
<style>
    .group-hover-visible { visibility: hidden; }
    .group-hover-container:hover .group-hover-visible { visibility: visible; opacity: 1 !important; }
    .extra-small { font-size: 0.75rem; }
    .hover-bg-light:hover { background-color: var(--bs-light) !important; }
    .cursor-pointer { cursor: pointer; }
</style>@endsection
