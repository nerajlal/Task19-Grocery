@extends('v5.layouts.app')

@section('title', 'All Perfumes | Afnan Luxury Collection')

@section('content')
    <div class="af-page-header">
        <div class="container">
            <h1 class="serif">All Perfumes</h1>
            <p>Explore our complete range of exquisite fragrances</p>
        </div>
    </div>

    <div class="container">
        <div class="af-listing-layout">
            <!-- Sidebar Filters -->
            <aside class="af-sidebar">
                <div class="af-filter-group">
                    <h4>Collections</h4>
                    <ul class="af-filter-links">
                        <li><a href="#" class="active">All Perfumes</a></li>
                        <li><a href="#">New Arrivals</a></li>
                        <li><a href="#">Best Sellers</a></li>
                    </ul>
                </div>

                <div class="af-filter-group">
                    <h4>Gender</h4>
                    <label class="af-checkbox"><input type="checkbox"> Men</label>
                    <label class="af-checkbox"><input type="checkbox"> Women</label>
                    <label class="af-checkbox"><input type="checkbox"> Unisex</label>
                </div>

                <div class="af-filter-group">
                    <h4>Shop By Price</h4>
                    <label class="af-checkbox"><input type="checkbox"> Under ₹1,999</label>
                    <label class="af-checkbox"><input type="checkbox"> ₹2,000 - ₹4,999</label>
                    <label class="af-checkbox"><input type="checkbox"> Above ₹5,000</label>
                </div>
            </aside>

            <!-- Product Listing -->
            <div class="af-main-listing">
                <div class="af-listing-toolbar">
                    <span class="af-count">{{ $products->count() }} Products</span>
                    <div class="af-sort">
                        <select>
                            <option>Sort By: Newest</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                        </select>
                    </div>
                </div>

                <div class="af-product-grid-listing">
                    @foreach($products as $product)
                        @include('v5.partials.product_card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <style>
        .af-page-header { padding: 80px 0 60px; text-align: center; background: #fff; }
        .af-page-header h1 { font-size: 42px; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 2px; }
        .af-page-header p { color: var(--af-gray); font-size: 14px; letter-spacing: 1px; }

        .af-listing-layout { display: grid; grid-template-columns: 280px 1fr; gap: 60px; margin-bottom: 100px; }

        .af-sidebar { position: sticky; top: 120px; height: fit-content; }
        .af-filter-group { margin-bottom: 40px; }
        .af-filter-group h4 { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        
        .af-filter-links { list-style: none; }
        .af-filter-links li { margin-bottom: 12px; }
        .af-filter-links a { text-decoration: none; color: var(--af-gray); font-size: 13px; transition: 0.3s; }
        .af-filter-links a:hover, .af-filter-links a.active { color: var(--af-black); font-weight: 600; }

        .af-checkbox { display: flex; align-items: center; gap: 12px; font-size: 13px; color: var(--af-gray); margin-bottom: 15px; cursor: pointer; }
        .af-checkbox input { accent-color: var(--af-black); }

        .af-listing-toolbar { display: flex; justify-content: space-between; align-items: center; padding-bottom: 20px; border-bottom: 1px solid var(--af-border); margin-bottom: 30px; }
        .af-count { font-size: 12px; font-weight: 600; color: var(--af-gray); text-transform: uppercase; letter-spacing: 1px; }
        .af-sort select { border: none; font-family: inherit; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; background: transparent; }

        .af-product-grid-listing { display: grid; grid-template-columns: repeat(3, 1fr); border-top: 1px solid var(--af-border); border-left: 1px solid var(--af-border); }

        @media (max-width: 1024px) {
            .af-listing-layout { grid-template-columns: 1fr; }
            .af-sidebar { display: none; }
            .af-product-grid-listing { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
@endsection
