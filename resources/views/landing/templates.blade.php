@extends('landing.layouts.vespr')

@section('title', 'Explore Templates — VESPR')

@section('styles')
<style>
  .templates-hero {
    padding: 160px 48px 80px;
    background: var(--cream);
    text-align: center;
    position: relative;
  }
  .templates-hero::after {
    content: '';
    position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);
    width: 1px; height: 60px; background: var(--sand);
  }

  .templates-grid {
    padding: 100px 48px;
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 64px;
  }

  .template-card {
    background: var(--white);
    border: 1px solid var(--sand);
    border-radius: 2px;
    overflow: hidden;
    transition: var(--transition);
    display: flex;
    flex-direction: column;
  }
  .template-card:hover {
    transform: translateY(-8px);
    border-color: var(--violet);
    box-shadow: 0 20px 40px rgba(0,0,0,0.05);
  }

  @keyframes autoScrollTemplates {
    0%, 8% {
      transform: translateY(0);
    }
    45%, 55% {
      transform: translateY(calc(-100% + 400px));
    }
    92%, 100% {
      transform: translateY(0);
    }
  }

  .template-preview {
    height: 400px;
    background: var(--warm);
    overflow: hidden;
    position: relative;
  }
  .template-preview img {
    width: 100%;
    height: auto;
    position: absolute;
    top: 0;
    left: 0;
    animation: autoScrollTemplates 18s ease-in-out infinite;
  }
  .template-card:hover .template-preview img {
    animation-play-state: paused;
  }

  .template-info {
    padding: 40px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }
  .template-tag {
    font-size: 10px;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--violet);
    font-weight: 500;
    margin-bottom: 12px;
  }
  .template-title {
    margin-bottom: 16px;
  }
  .template-desc {
    margin-bottom: 24px;
  }
  .template-features {
    list-style: none;
    margin-bottom: 32px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }
  .template-features li {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .section-desc {
    max-width: 580px;
  }
  .template-features li::before {
    content: '◈';
    color: var(--violet);
    font-size: 10px;
  }

  .template-actions {
    margin-top: auto;
  }

  @media (max-width: 900px) {
    .templates-grid {
      grid-template-columns: 1fr;
      gap: 40px;
      padding: 60px 24px;
    }
    .template-info { padding: 32px 24px; }
  }

  @media (max-width: 600px) {
    .templates-hero { padding: 120px 24px 60px; }
    .template-title { font-size: 28px; }
  }

  /* ── ADMIN PANEL CENTRALIZED MANAGEMENT ── */
  .admin-showcase-section {
    background: var(--cream);
    border-top: 1px solid var(--sand);
    border-bottom: 1px solid var(--sand);
    padding: 120px 48px;
  }
  .admin-showcase-inner {
    max-width: 1300px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1.55fr;
    gap: 56px;
    align-items: center;
  }
  .admin-showcase-left {
    text-align: left;
  }
  .admin-showcase-right {
    width: 100%;
  }
  .admin-browser-frame {
    border: 1px solid var(--sand);
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.03);
    background: var(--white);
  }
  .admin-browser-header {
    padding: 12px 18px;
    background: #faf8f5;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid var(--sand);
  }
  .admin-browser-dots {
    display: flex;
    gap: 6px;
  }
  .admin-browser-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
  }
  .admin-video-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 16 / 9;
    background: #000;
  }
  .admin-video-wrapper iframe {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    border: 0;
  }
  .admin-feature-list {
    margin-top: 36px;
    display: grid;
    gap: 24px;
  }
  .admin-feature-item {
    display: flex;
    gap: 16px;
    align-items: flex-start;
  }
  .admin-feature-num {
    font-family: var(--serif);
    font-size: 16px;
    color: var(--violet);
    border-bottom: 1px solid var(--sand);
    padding-bottom: 2px;
  }
  .admin-feature-content h4 {
    margin-bottom: 4px;
  }
  .admin-feature-content p {
    line-height: 1.5;
  }

  @media (max-width: 900px) {
    .admin-showcase-section {
      padding: 60px 24px;
    }
    .admin-showcase-inner {
      grid-template-columns: 1fr;
      gap: 40px;
    }
    .admin-showcase-left {
      order: 2;
    }
    .admin-showcase-right {
      order: 1;
    }
  }
</style>
@endsection

@section('content')
<section class="templates-hero">
  <p class="section-label">Digital Excellence</p>
  <h1 class="section-title">Explore our<br/><em>curated templates</em></h1>
  <p class="section-desc" style="margin: 0 auto;">From high-conversion editorial layouts to minimalist boutique designs, discover the perfect digital home for your fragrance brand.</p>
</section>

<section class="templates-grid">
  <!-- V3 Aura -->
  <div class="template-card">
    <div class="template-preview">
      <img src="{{ asset('Images/landing/v3-template.png') }}" alt="Aura Template">
    </div>
    <div class="template-info">
      <span class="template-tag">Modern Luxury</span>
      <h3 class="template-title">Aura</h3>
      <p class="template-desc">Our most advanced template, featuring a center-focused header hierarchy, premium typography, and editorial product showcases.</p>
      <ul class="template-features">
        <li>Center Header</li>
        <li>Instrument Sans</li>
        <li>Quick-Add</li>
        <li>SEO Optimized</li>
      </ul>
      <div class="template-actions">
        <a href="javascript:void(0)" onclick="openDemoAccess(event, '{{ route('v3.home') }}')" class="btn-primary" style="width: 100%; text-align: center;">View Live Demo</a>
      </div>
    </div>
  </div>

  <!-- V2 Velvet -->
  <div class="template-card">
    <div class="template-preview">
      <img src="{{ asset('Images/landing/v2-template.png') }}" alt="Velvet Template">
    </div>
    <div class="template-info">
      <span class="template-tag">Minimalist Noir</span>
      <h3 class="template-title">Velvet</h3>
      <p class="template-desc">A dark, sophisticated aesthetic designed for high-end boutique collections and exclusive releases.</p>
      <ul class="template-features">
        <li>Sidebar Nav</li>
        <li>Dark Mode</li>
        <li>Parallax</li>
        <li>Rich Gallery</li>
      </ul>
      <div class="template-actions">
        <a href="javascript:void(0)" onclick="openDemoAccess(event, '{{ route('velvet.home') }}')" class="btn-primary" style="width: 100%; text-align: center;">View Live Demo</a>
      </div>
    </div>
  </div>

  <!-- V4 Heritage -->
  <div class="template-card">
    <div class="template-preview">
      <img src="{{ asset('Images/landing/v4-template.png') }}" alt="Heritage Template">
    </div>
    <div class="template-info">
      <span class="template-tag">Classic Elegance</span>
      <h3 class="template-title">Heritage</h3>
      <p class="template-desc">Traditional layouts meeting modern performance. Perfect for established brands with large catalogs.</p>
      <ul class="template-features">
        <li>Wide Grid</li>
        <li>Mega Menu</li>
        <li>Advanced Filters</li>
        <li>Blog Integrated</li>
      </ul>
      <div class="template-actions">
        <a href="javascript:void(0)" onclick="openDemoAccess(event, '{{ route('v4.home') }}')" class="btn-primary" style="width: 100%; text-align: center;">View Live Demo</a>
      </div>
    </div>
  </div>

  <!-- V1 Classic -->
  <div class="template-card">
    <div class="template-preview">
      <img src="{{ asset('Images/landing/v1-template.png') }}" alt="Classic Template">
    </div>
    <div class="template-info">
      <span class="template-tag">Legacy Theme</span>
      <h3 class="template-title">Classic</h3>
      <p class="template-desc">The theme that started it all. A balanced, clean approach to perfume storytelling and commerce.</p>
      <ul class="template-features">
        <li>Clean White</li>
        <li>Story-Focused</li>
        <li>Simple Flows</li>
        <li>Mobile First</li>
      </ul>
      <div class="template-actions">
        <a href="javascript:void(0)" onclick="openDemoAccess(event, '{{ route('v1.home') }}')" class="btn-primary" style="width: 100%; text-align: center;">View Live Demo</a>
      </div>
    </div>
  </div>
</section>

<!-- CENTRALIZED ADMIN MANAGEMENT SHOWCASE -->
<section class="admin-showcase-section">
  <div class="admin-showcase-inner">
    <!-- Left Column: Copywriting & Bullet list -->
    <div class="admin-showcase-left">
      <p class="section-label">Centralized Operations</p>
      <h2 class="section-title" style="font-size: 40px; font-weight: 700; line-height: 1.25; margin-bottom: 20px;">One unified dashboard.<br/><em>All your storefront themes.</em></h2>
      <p class="section-desc" style="max-width: 100%; margin-bottom: 32px; font-size: 14px; line-height: 1.7; color: var(--bark); font-weight: 400;">Whichever exquisite storefront template you select to tell your brand's olfactory story, your operations remain beautifully simple. Centralize your inventory, manage product listings, configure custom checkout paths, and direct customer experiences inside the unified VESPR Admin Panel.</p>
      
      <div class="admin-feature-list">
        <div class="admin-feature-item">
          <div class="admin-feature-num">01</div>
          <div class="admin-feature-content">
            <h4>Centrally Managed Scent Bundles</h4>
            <p>Design, track, and optimize custom perfume bundles (e.g. extracts paired with travel sets) directly inside your central admin interface. Changes sync instantly to any active storefront template.</p>
          </div>
        </div>
        <div class="admin-feature-item">
          <div class="admin-feature-num">02</div>
          <div class="admin-feature-content">
            <h4>Unified Olfactory Pyramids</h4>
            <p>Upload and manage ingredients, structures, and scent note descriptors centrally, helping buyers across all storefronts discover their perfect fragrance.</p>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Right Column: Autoplay browser mockup walkthrough video -->
    <div class="admin-showcase-right">
      <div class="admin-browser-frame">
        <div class="admin-browser-header">
          <div class="admin-browser-dots">
            <div class="admin-browser-dot" style="background: #FF5F56;"></div>
            <div class="admin-browser-dot" style="background: #FFBD2E;"></div>
            <div class="admin-browser-dot" style="background: #27C93F;"></div>
          </div>
          <div style="font-family: var(--sans); font-size: 11px; letter-spacing: 0.5px; color: var(--bark); font-weight: 400;">vespr.store /admin panel</div>
          <div style="width: 32px;"></div>
        </div>
        <div class="admin-video-wrapper" style="aspect-ratio: 1.8285714285714285;">
          <style>
            wistia-player[media-id='0dhesptrqu']:not(:defined) {
              background: center / contain no-repeat url('https://fast.wistia.com/embed/medias/0dhesptrqu/swatch');
              display: block;
              filter: blur(5px);
              padding-top: 54.69%;
            }
          </style>
          <wistia-player media-id="0dhesptrqu" aspect="1.8285714285714285" autoplay="true" muted="true" end-video-behavior="loop" playbar="false" style="display: block; width: 100%; height: 100%;"></wistia-player>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Call to Action -->
<section style="background: var(--warm); text-align: center; padding: 100px 48px;">
  <p class="section-label">Custom Design</p>
  <h2 class="section-title">Need a unique<br/><em>digital identity?</em></h2>
  <p class="section-desc" style="margin: 0 auto 40px;">We can craft a bespoke fragrance experience tailored specifically to your brand heritage.</p>
  <a href="{{ route('landing') }}#contact" class="btn-primary">Request Custom Theme</a>
</section>
@endsection

@section('scripts')
  <script src="https://fast.wistia.com/player.js" async></script>
  <script src="https://fast.wistia.com/embed/0dhesptrqu.js" async type="module"></script>
@endsection