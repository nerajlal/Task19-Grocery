# Grocery Storefront Landing Page Wireframe & Theme Structure

This document outlines the complete section-by-section UI wireframe, CSS variables structure, and component hierarchy of **`template_1`** to serve as a reference template for building future storefront themes.

---

## 1. Core Layout Structure (HTML Grid & Flex Layout)

```
+-----------------------------------------------------------+
| [Header] Logo | Search (Green Accent) | Acc / Login | Cart |
+-----------------------------------------------------------+
|                                                           |
|  [Sidebar Menu]           [Main Content Area]             |
|  - All Products           +----------------------------+  |
|  - Weekly Combos          |  [Hero Banner]             |  |
|  - Category 1             |  Green gradient            |  |
|  - Category 2             |  Text & "Shop Now" button  |  |
|  - Category 3             +----------------------------+  |
|                           |  [USP trust bar]           |  |
|                           |  4 Items (Farm, Express)   |  |
|                           +----------------------------+  |
|                           |  [Category Section 1]      |  |
|                           |  Grid of Product Cards     |  |
|                           +----------------------------+  |
|                           |  [Weekly Combos Grid]      |  |
|                           |  Grid of Combo Cards       |  |
|                           +----------------------------+  |
|                           |  [Newsletter Banner]       |  |
|                           |  Dark bg, Email & Sub btn  |  |
|                           +----------------------------+  |
+-----------------------------------------------------------+
| [Footer] Brand Info / Trust | Categories | Care | News    |
+-----------------------------------------------------------+
```

---

## 2. Design Tokens & Styling Constants (CSS Variables)

When creating a new theme matching this structure, define these core styling tokens in your primary stylesheet:

```css
:root {
    --primary-color: #0f172a;       /* Slate Dark for primary typography */
    --accent-color: #10b981;        /* Vibrant Emerald Green for primary brand focus */
    --accent-hover: #059669;        /* Hover state for primary buttons */
    --bg-light: #f8fafc;            /* Soft background gray for main content container */
    --border-color: #e2e8f0;        /* Light grey dividers and card outlines */
    --text-muted: #64748b;          /* Secondary typography */
}
```

---

## 3. UI Component Specs

### A. Sticky Header Component
- **Left**: Mobile Toggle Button (hidden on desktop) + Store Logo (`<i class="fa-solid fa-basket-shopping"></i>` + Tenant Name).
- **Middle**: Search bar with light background, matching accent border on focus.
- **Right**: User profile action button + Shopping Cart Action Trigger displaying the dynamically calculated item quantity badge.

### B. Hero Banner Component
- **Layout**: 2-column layout (flexbox/grid) that collapses responsively on mobile.
- **Left Column**: Title, subtitle, and primary call-to-action button (pill-shaped, green background with soft shadow).
- **Right Column**: Featured product basket image.
- **Background**: Soft gradient (e.g., `#ecfdf5` to `#d1fae5`) matching the organic theme.

### C. USP Trust Bar Component
- **Layout**: Grid (minmax 200px) containing 4 key trust cards.
- **Items**:
  1. *100% Farm Fresh* - Sourced directly from local farms.
  2. *2-Hour Delivery* - Express delivery to doorstep.
  3. *Hygienically Packed* - Handled with strict safety protocols.
  4. *No Questions Return* - Instant returns at delivery window.

### D. Product Card Component
- **Image Section**: Square ratio `100% padding-top` wrapper. Renders product thumbnail with fallback support.
- **Badges**:
  - *Popular / Trend Badge*: Bottom-left overlaid label.
  - *Pack Deal Badge*: Top-left purple/blue badge (`<i class="fa-solid fa-boxes-stacked"></i>` + "Pack Deal") visible only if volume/bundle discounts exist.
- **Details Section**:
  - Price: Bold, colored in green accent.
  - Title: 2-line truncated text clamp.
  - Meta: Product type + unit weight/size (e.g. `Vegetables • 500g`).
- **Action Button**: Floating circular absolute button (`+` icon) to add directly to cart.

### E. Combo / Bundle Card Component
- **Image Section**: Square product grouping thumbnail with a "Save Bundle" ribbon.
- **Details Section**: Price, title, and quantity of products included.
- **Action Button**: Add to cart with type indicator set to `'bundle'`.

---

## 4. DOM Hierarchy Reference

```html
<!-- Layout Wrapper -->
<div class="main-wrapper">
    <!-- Sidebar Navigation -->
    <aside class="sidebar">...</aside>
    
    <!-- Main Content Container -->
    <main class="main-content">
        <div class="content-container">
            <!-- 1. Hero Section -->
            <div class="hero-banner">...</div>
            
            <!-- 2. USP Row -->
            <div class="usp-bar">...</div>
            
            <!-- 3. Category Product Rows -->
            <div class="department-section">
                <div class="section-header">...</div>
                <div class="product-grid">
                    <!-- Product Cards -->
                </div>
            </div>
            
            <!-- 4. Combos Rows -->
            <div class="department-section">...</div>
            
            <!-- 5. Footer -->
            <footer class="store-footer">...</footer>
        </div>
    </main>
</div>
```

---

## 5. Collection / Products List Page Layout

This page is loaded for specific categories (e.g. Vegetables, Dairy) or the global product catalog.

```
+-----------------------------------------------------------+
| [Header] Logo | Search (Green Accent) | Acc / Login | Cart |
+-----------------------------------------------------------+
|                                                           |
|  [Sidebar Menu]           [Main Content Area]             |
|  - All Products           +----------------------------+  |
|  - Weekly Combos          |  [Collection Header]       |  |
|  - Category 1             |  Collection Name           |  |
|  - Category 2             |  Total items count badge   |  |
|  - Category 3             +----------------------------+  |
|                           |  [Weekly Combos Grid]      |  |
|                           |  (Optional section)        |  |
|                           +----------------------------+  |
|                           |  [Products Grid]           |  |
|                           |  Responsive grid of grocery|  |
|                           |  product cards             |  |
|                           +----------------------------+  |
+-----------------------------------------------------------+
| [Footer] Brand Info / Trust | Categories | Care | News    |
+-----------------------------------------------------------+
```

### Components specific to this page:
- **Collection Header**: Renders the dynamic `$title` of the active category with a subtitle describing the items. Includes a card on the right displaying the total number of items found.
- **Empty State Display**: Shown if no products match the category. Features a shopping bag icon, a helpful text instruction, and a "Return Home / Shop All" primary action button.

---

## 6. General Content & Policy Page Layout

For simple text pages such as Shipping Policy, Return Policy, and Terms of Service.

```
+-----------------------------------------------------------+
| [Header] Logo | Search (Green Accent) | Acc / Login | Cart |
+-----------------------------------------------------------+
|                                                           |
|             [Centered Main Content Container]             |
|             Max-width: 800px                              |
|             Card background (#fff) with border            |
|             +---------------------------------------+     |
|             |  [Page Title (H1)]                    |     |
|             |  [Introductory Paragraph]             |     |
|             |  [Policy Sections (H2 + body text)]   |     |
|             +---------------------------------------+     |
|                                                           |
+-----------------------------------------------------------+
| [Footer] Brand Info / Trust | Categories | Care | News    |
+-----------------------------------------------------------+
```

---

## 7. Product Detail Page Layout

For individual product specifications, sizing options, and bulk pack offers.

```
+-----------------------------------------------------------+
| [Header] Logo | Search (Green Accent) | Acc / Login | Cart |
+-----------------------------------------------------------+
|                                                           |
|             [Breadcrumb Navigation]                       |
|             Home > Shop > Product Name                    |
|             +---------------------------------------+     |
|             |  [Product Gallery] | [Product Info]   |     |
|             |  Main Image        | Category / Badge |     |
|             |  Thumbnails Grid   | Product Title    |     |
|             |                    | Current/Compare  |     |
|             |                    | Price            |     |
|             |                    |------------------|     |
|             |                    | Variant Select   |     |
|             |                    | (Weight Options) |     |
|             |                    |------------------|     |
|             |                    | Volume Pack Deals|     |
|             |                    | (dashed borders) |     |
|             |                    |------------------|     |
|             |                    | Quantity Selector|     |
|             |                    | & Add to Bag btn |     |
|             |                    |------------------|     |
|             |                    | Description Tabs |     |
|             +---------------------------------------+     |
|                                                           |
|             [Related Products / Recommendations]          |
|             Grid of 4 Recommended Product Cards           |
|                                                           |
+-----------------------------------------------------------+
| [Footer] Brand Info / Trust | Categories | Care | News    |
+-----------------------------------------------------------+
```

### Components specific to this page:
- **Variant Selector**: Dynamic pill elements allowing selection of weight options (e.g. `500g`, `1kg`) which update the displayed price dynamically.
- **Volume Pack Deals**: Highlighted DAShed card rows displaying special bulk pack offers (e.g. `Pack of 3 - Save ₹60 instantly`) linked to the bundle cart controller.
- **Related Products**: Underneath the main detail grid, loops through similar items in the same collection.

---

## 8. Combos & Weekly Deals Page Layout

This page lists all special mix & match combos, bundle deals, and volume package offers.

```
+-----------------------------------------------------------+
| [Header] Logo | Search (Green Accent) | Acc / Login | Cart |
+-----------------------------------------------------------+
|                                                           |
|  [Sidebar Menu]           [Main Content Area]             |
|  - All Products           +----------------------------+  |
|  - Weekly Combos          |  [Collection Header]       |  |
|  - Category 1             |  "Weekly Grocery Combos"   |  |
|  - Category 2             |  Total combos count badge  |  |
|  - Category 3             +----------------------------+  |
|                           |  [Combos Grid]             |  |
|                           |  Grid of Combo Cards       |  |
|                           |  showing savings value     |  |
|                           +----------------------------+  |
+-----------------------------------------------------------+
| [Footer] Brand Info / Trust | Categories | Care | News    |
+-----------------------------------------------------------+
```

### Components specific to this page:
- **Combo Card**: Rendered with a square thumbnail layout, including a "Save Bundle" or "Volume Deal" top-right badge, original retail price vs discount price display, and an add-to-bag action specifying type as `'bundle'`.
- **Empty State Display**: Displays a layer-group icon, description, and redirect button back to the main catalog if no active bundles exist in the tenant's store.




