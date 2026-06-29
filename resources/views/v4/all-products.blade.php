@extends('v4.layouts.app')

@section('title', 'All Perfumes | Task19 Luxury Collection')

@section('content')
    <div class="a-page-header">
        <div class="container">
            <h1 class="serif">The Entire Collection</h1>
            <p>Explore our curated world of artisanal fragrances</p>
        </div>
    </div>

    <div class="container">
        <div class="a-listing-layout">
            <!-- Sidebar / Filters -->
            <aside class="a-listing-sidebar">
                <div class="a-filter-group">
                    <h3>Categories</h3>
                    <ul class="a-filter-links">
                        <li><a href="#" class="active">All Products</a></li>
                        <li><a href="#">New Arrivals</a></li>
                        <li><a href="#">Bestsellers</a></li>
                        <li><a href="#">Signature Oudh</a></li>
                    </ul>
                </div>

                <div class="a-filter-group">
                    <h3>Fragrance Family</h3>
                    <div class="a-checkbox-group">
                        <label class="a-checkbox">
                            <input type="checkbox"> <span>Floral</span>
                        </label>
                        <label class="a-checkbox">
                            <input type="checkbox"> <span>Fresh</span>
                        </label>
                        <label class="a-checkbox">
                            <input type="checkbox"> <span>Oriental</span>
                        </label>
                        <label class="a-checkbox">
                            <input type="checkbox"> <span>Woody</span>
                        </label>
                    </div>
                </div>
            </aside>

            <!-- Product Grid -->
            <div class="a-listing-main">
                <div class="a-listing-toolbar">
                    <div class="a-result-count">{{ $products->count() }} Products Found</div>
                    <div class="a-sort-box">
                        <label>Sort By:</label>
                        <select>
                            <option>Newest First</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Best Selling</option>
                        </select>
                    </div>
                </div>

                <div class="a-product-grid-listing">
                    @foreach($products as $product)
                        @include('v4.partials.product_card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <style>
        .a-page-header {
            padding: 40px 0;
            text-align: center;
            background: #fff;
            margin-bottom: 20px;
        }

        .a-page-header h1 { font-size: 42px; margin-bottom: 10px; }
        .a-page-header p { color: var(--text-muted); font-size: 14px; text-transform: uppercase; letter-spacing: 2px; }

        .a-listing-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 30px;
        }

        .a-listing-sidebar {
            position: sticky;
            top: 120px;
            height: fit-content;
        }

        .a-filter-group { margin-bottom: 40px; }
        .a-filter-group h3 {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 10px;
        }

        .a-filter-links { list-style: none; }
        .a-filter-links li { margin-bottom: 12px; }
        .a-filter-links a {
            text-decoration: none;
            color: var(--text-muted);
            font-size: 14px;
            transition: 0.3s;
        }
        .a-filter-links a.active, .a-filter-links a:hover { color: var(--accent); font-weight: 600; }

        .a-checkbox-group { display: flex; flex-direction: column; gap: 12px; }
        .a-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: var(--text-muted);
            cursor: pointer;
        }
        .a-checkbox input { accent-color: var(--accent); width: 16px; height: 16px; }

        .a-listing-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        .a-result-count { font-size: 13px; font-weight: 600; color: var(--text-muted); }
        
        .a-sort-box { display: flex; align-items: center; gap: 15px; }
        .a-sort-box label { font-size: 12px; text-transform: uppercase; font-weight: 700; color: var(--text-muted); }
        .a-sort-box select {
            border: none;
            background: none;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            outline: none;
            cursor: pointer;
            color: var(--primary);
        }

        .a-product-grid-listing {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px 30px;
        }

        @media (max-width: 1200px) {
            .a-product-grid-listing { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 991px) {
            .a-listing-layout { grid-template-columns: 1fr; }
            .a-listing-sidebar { display: none; }
            .a-product-grid-listing { 
                grid-template-columns: repeat(2, 1fr); 
                gap: 15px;
            }
            .a-page-header { padding: 30px 15px; }
            .a-page-header h1 { font-size: 28px; }
            .a-listing-toolbar { flex-direction: column; gap: 15px; align-items: flex-start; }
        }

        @media (max-width: 480px) {
            .a-product-grid-listing { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
@endsection
