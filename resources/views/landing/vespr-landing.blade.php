@extends('landing.layouts.vespr')

@section('styles')
  <style>
    /* ── HERO ── */
    .hero {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 120px 48px 80px;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse 60% 50% at 50% 60%, rgba(124, 92, 138, 0.08) 0%, transparent 70%);
      pointer-events: none;
    }

    .hero-eyebrow {
      font-family: var(--sans);
      font-size: 11px;
      font-weight: 500;
      letter-spacing: 4px;
      text-transform: uppercase;
      color: var(--violet);
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .hero-eyebrow::before,
    .hero-eyebrow::after {
      content: '';
      width: 32px;
      height: 1px;
      background: var(--violet-l);
    }

    .hero h1 {
      font-family: var(--serif);
      font-size: clamp(56px, 8vw, 110px);
      font-weight: 300;
      line-height: 1.05;
      letter-spacing: -1px;
      color: var(--ink);
      margin-bottom: 12px;
    }

    .hero h1 em {
      font-style: italic;
      color: var(--violet);
    }

    .hero-sub {
      font-family: var(--sans);
      font-size: 17px;
      font-weight: 400;
      color: var(--bark);
      max-width: 480px;
      margin: 20px auto 48px;
      line-height: 1.8;
    }

    .hero-actions {
      display: flex;
      gap: 16px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .hero-trust {
      margin-top: 64px;
      font-size: 11px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--bark);
    }

    .hero-brands {
      display: flex;
      gap: 40px;
      justify-content: center;
      margin-top: 16px;
      flex-wrap: wrap;
    }

    .hero-brands span {
      font-family: var(--serif);
      font-size: 16px;
      font-weight: 600;
      letter-spacing: 2px;
      color: var(--sand);
    }

    /* ── SECTION COMMONS ── */
    section {
      padding: 100px 48px;
    }

    .section-desc {
      max-width: 520px;
    }

    /* ── ONBOARDING ── */
    .onboarding {
      background: var(--white);
    }

    .onboarding-inner {
      max-width: 1100px;
      margin: 0 auto;
    }

    .onboarding-head {
      text-align: center;
      margin-bottom: 72px;
    }

    .onboarding-head .section-desc {
      margin: 0 auto;
    }

    .steps {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 2px;
    }

    .step {
      background: var(--cream);
      padding: 40px 32px;
      position: relative;
      transition: background var(--transition);
    }

    .step:hover {
      background: var(--warm);
    }

    .step-num {
      font-family: var(--serif);
      font-size: 72px;
      font-weight: 300;
      color: var(--sand);
      line-height: 1;
      margin-bottom: 20px;
    }

    .step-title {
      margin-bottom: 12px;
    }

    .step-tag {
      display: inline-block;
      margin-top: 20px;
      font-size: 11px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--violet);
      font-weight: 500;
    }

    .step-connector {
      position: absolute;
      top: 52px;
      right: -18px;
      width: 36px;
      height: 1px;
      background: var(--sand);
      z-index: 2;
    }

    .step:last-child .step-connector {
      display: none;
    }

    /* ── FEATURES SHOWCASE ── */
    .features {
      background: var(--cream);
      padding: 120px 48px;
    }

    .features-inner {
      max-width: 1200px;
      margin: 0 auto;
    }

    .features-head {
      text-align: center;
      margin-bottom: 72px;
    }

    .features-head .section-desc {
      margin: 0 auto;
    }

    .features-showcase {
      display: grid;
      grid-template-columns: 350px 1fr;
      gap: 64px;
      align-items: center;
    }

    .features-tabs {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .feature-tab {
      background: transparent;
      border: 1px solid transparent;
      padding: 20px 24px;
      text-align: left;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 16px;
      border-radius: 4px;
      transition: var(--transition);
      width: 100%;
    }

    .feature-tab:hover {
      background: rgba(237, 230, 214, 0.5);
    }

    .feature-tab.active {
      background: var(--white);
      border-color: var(--sand);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    }

    .tab-icon {
      font-size: 18px;
      color: var(--stone);
      transition: color 0.3s ease;
      width: 24px;
      text-align: center;
    }

    .feature-tab.active .tab-icon {
      color: var(--violet);
    }

    .tab-label {
      font-family: var(--serif);
      font-size: 20px;
      font-weight: 400;
      color: var(--ink);
    }

    /* Browser Mockup Frame */
    .features-preview {
      background: var(--white);
      border: 1px solid var(--sand);
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 30px 60px rgba(30, 26, 22, 0.08);
      position: relative;
    }

    .browser-header {
      background: var(--ink);
      padding: 16px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .browser-dots {
      display: flex;
      gap: 8px;
    }

    .browser-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
    }

    .browser-title {
      font-family: var(--sans);
      font-size: 11px;
      color: rgba(255, 255, 255, 0.4);
      letter-spacing: 2px;
      text-transform: uppercase;
    }

    .browser-actions {
      display: flex;
      gap: 12px;
    }

    .browser-btn-dummy {
      width: 12px;
      height: 12px;
      border-radius: 2px;
      background: rgba(255, 255, 255, 0.2);
    }

    .browser-content {
      position: relative;
      width: 100%;
      aspect-ratio: 2940 / 1606;
      background: var(--warm);
      overflow: hidden;
    }

    .tab-content {
      position: absolute;
      inset: 0;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.5s ease, visibility 0.5s ease;
      display: flex;
      flex-direction: column;
    }

    .tab-content.active {
      opacity: 1;
      visibility: visible;
      z-index: 2;
    }

    .tab-content-img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      background: var(--white);
    }

    /* ── TAB CONTENT SLIDESHOW ── */
    .tab-slideshow {
      position: relative;
      width: 100%;
      height: 100%;
      overflow: hidden;
      background: var(--white);
    }
    
    .tab-slideshow .slide {
      position: absolute;
      inset: 0;
      opacity: 0;
      transition: opacity 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      z-index: 1;
    }
    
    .tab-slideshow .slide.active {
      opacity: 1;
      z-index: 2;
    }
    
    .slide-controls {
      position: absolute;
      top: 24px;
      right: 24px;
      display: flex;
      align-items: center;
      gap: 12px;
      z-index: 15;
    }
    
    .slide-nav-btn {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(8px);
      border: 1px solid var(--sand);
      border-radius: 50%;
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      cursor: pointer;
      color: var(--stone);
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(30, 26, 22, 0.08);
    }
    
    .slide-nav-btn:hover {
      background: var(--ink);
      color: var(--white);
      border-color: var(--ink);
    }
    
    .slide-dots {
      display: flex;
      gap: 6px;
    }
    
    .slide-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: rgba(30, 26, 22, 0.15);
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .slide-dot.active {
      background: var(--violet);
      width: 14px;
      border-radius: 3px;
    }

    .tab-content-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: linear-gradient(to top, rgba(30, 26, 22, 0.85) 0%, rgba(30, 26, 22, 0.4) 60%, transparent 100%);
      padding: 40px;
      color: var(--white);
      display: flex;
      flex-direction: column;
      gap: 8px;
      text-align: left;
    }

    .tab-content-title {
      font-family: var(--sans);
      font-size: 24px;
      font-weight: 500;
      color: var(--white);
    }

    .tab-content-desc {
      font-family: var(--sans);
      font-size: 16px;
      font-weight: 400;
      color: rgba(255, 255, 255, 0.95);
      line-height: 1.6;
      max-width: 600px;
    }

    /* ── CHECKOUT MOCKUP SHOWCASE ── */
    .checkout-mockup {
      display: grid;
      grid-template-columns: 1.2fr 1fr;
      height: 100%;
      background: var(--white);
      color: var(--ink);
    }

    .checkout-form-pane {
      padding: 32px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      border-right: 1px solid var(--sand);
      text-align: left;
    }

    .checkout-brand-header {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 24px;
    }

    .checkout-lock-icon {
      color: var(--violet);
      font-size: 14px;
    }

    .checkout-secure-title {
      font-family: var(--sans);
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: var(--stone);
      font-weight: 500;
    }

    .checkout-field-group {
      margin-bottom: 16px;
    }

    .checkout-label {
      font-family: var(--sans);
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--stone);
      margin-bottom: 8px;
      display: block;
      font-weight: 500;
    }

    .checkout-card-input-wrapper {
      position: relative;
      margin-bottom: 12px;
    }

    .checkout-card-brand-icon {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: #1A1F71;
      font-size: 20px;
    }

    .checkout-input {
      width: 100%;
      background: var(--cream);
      border: 1px solid var(--sand);
      border-radius: 4px;
      padding: 12px 16px;
      font-family: var(--sans);
      font-size: 14px;
      color: var(--ink);
      transition: border-color 0.3s ease;
      outline: none;
    }

    .checkout-input:focus {
      border-color: var(--violet);
    }

    .checkout-row-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }

    .checkout-btn-pay {
      background: var(--ink);
      color: var(--white);
      border: none;
      border-radius: 4px;
      padding: 16px;
      font-family: var(--sans);
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 2px;
      font-weight: 500;
      cursor: pointer;
      transition: background 0.3s ease;
      margin-top: 8px;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
    }

    .checkout-btn-pay:hover {
      background: var(--violet);
    }

    .checkout-secure-footer {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      font-family: var(--sans);
      font-size: 11px;
      color: var(--stone);
      margin-top: 24px;
    }

    .checkout-summary-pane {
      background: var(--warm);
      padding: 32px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      text-align: left;
    }

    .summary-title {
      font-family: var(--serif);
      font-size: 22px;
      color: var(--ink);
      margin-bottom: 24px;
      font-weight: 400;
    }

    .summary-product {
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 24px;
    }

    .summary-product-img {
      width: 56px;
      height: 56px;
      border-radius: 4px;
      background-size: cover;
      background-position: center;
      border: 1px solid var(--sand);
      flex-shrink: 0;
    }

    .summary-product-info {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .product-title {
      font-family: var(--serif);
      font-size: 16px;
      color: var(--ink);
      font-weight: 400;
    }

    .product-desc {
      font-family: var(--sans);
      font-size: 12px;
      color: var(--stone);
    }

    .product-price {
      font-family: var(--sans);
      font-size: 14px;
      font-weight: 500;
      color: var(--ink);
    }

    .summary-divider {
      height: 1px;
      background: var(--sand);
      margin: 20px 0;
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      font-family: var(--sans);
      font-size: 13px;
      color: var(--stone);
      margin-bottom: 12px;
    }

    .shipping-free {
      color: var(--violet);
      font-weight: 500;
      letter-spacing: 1px;
    }

    .summary-row.total {
      font-family: var(--serif);
      font-size: 22px;
      color: var(--ink);
      font-weight: 400;
      margin-bottom: 0;
    }

    /* ── SCENT BUNDLING SLIDER ── */
    .bundle-slider {
      position: relative;
      width: 100%;
      height: 100%;
      overflow: hidden;
    }

    .bundle-slide {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: contain;
      background: var(--white);
      opacity: 0;
      transition: opacity 0.5s ease;
    }

    .bundle-slide:nth-child(1) {
      animation: bundleFade1 10s infinite ease-in-out;
    }

    .bundle-slide:nth-child(2) {
      animation: bundleFade2 10s infinite ease-in-out;
    }

    .browser-content:hover .bundle-slide {
      animation-play-state: paused;
    }

    @keyframes bundleFade1 {

      0%,
      45%,
      100% {
        opacity: 1;
        z-index: 2;
      }

      50%,
      95% {
        opacity: 0;
        z-index: 1;
      }
    }

    @keyframes bundleFade2 {

      0%,
      45%,
      100% {
        opacity: 0;
        z-index: 1;
      }

      50%,
      95% {
        opacity: 1;
        z-index: 2;
      }
    }

    @media (max-width: 900px) {
      .features-showcase {
        grid-template-columns: 1fr;
        gap: 40px;
      }

      .features-tabs {
        flex-direction: row;
        overflow-x: auto;
        padding-bottom: 12px;
        -webkit-overflow-scrolling: touch;
      }

      .feature-tab {
        flex-shrink: 0;
        width: auto;
        padding: 14px 20px;
      }

      .features-preview {
        border: 1px solid var(--sand);
        border-radius: 8px;
        overflow: hidden;
      }

      .browser-content {
        height: auto;
        aspect-ratio: auto;
        overflow: visible;
        background: transparent;
      }

      .tab-content {
        position: relative;
        opacity: 1;
        visibility: visible;
        display: none;
        background: var(--white);
      }

      .tab-content.active {
        display: flex;
      }

      .tab-content-img {
        width: 100%;
        height: auto;
        aspect-ratio: 2940 / 1606;
        object-fit: contain;
        border-bottom: 1px solid var(--sand);
      }

      .tab-slideshow {
        width: 100%;
        aspect-ratio: 2940 / 1606;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid var(--sand);
      }

      .tab-slideshow .tab-content-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-bottom: none;
      }

      .tab-content-overlay {
        position: relative;
        background: var(--cream);
        padding: 24px 20px;
        color: var(--ink);
        text-align: left;
      }

      .tab-content-title {
        color: var(--ink);
        font-size: 18px;
        font-family: var(--serif);
        margin-bottom: 6px;
      }

      .tab-content-desc {
        color: var(--stone);
        font-size: 13px;
        line-height: 1.5;
        max-width: 100%;
      }
    }

    /* ── VIDEO SHOWCASE (SIDE-BY-SIDE COMPACT) ── */
    .video-showcase {
      background: var(--cream);
      padding: 120px 48px;
      border-top: 1px solid var(--sand);
      border-bottom: 1px solid var(--sand);
    }
    
    .video-showcase-inner {
      max-width: 1350px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 8fr 2fr;
      gap: 48px;
      align-items: center;
    }
    
    .video-showcase-left {
      width: 100%;
    }
    
    .video-showcase-right {
      width: 100%;
      text-align: left;
    }
    
    .video-browser-frame {
      border: 1px solid var(--sand);
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(0,0,0,0.03);
      background: var(--white);
    }
    
    .video-browser-header {
      padding: 12px 18px;
      background: #faf8f5;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid var(--sand);
    }
    
    .video-browser-dots {
      display: flex;
      gap: 6px;
    }
    
    .video-browser-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
    }
    
    .video-browser-title {
      font-family: var(--sans);
      font-size: 11px;
      letter-spacing: 0.5px;
      color: var(--stone);
      font-weight: 400;
    }
    
    .video-wrapper-inner {
      position: relative;
      width: 100%;
      aspect-ratio: 16 / 9;
      background: #000;
    }
    
    .video-wrapper-inner iframe {
      position: absolute;
      top: 0; left: 0; width: 100%; height: 100%;
      border: 0;
    }
    
    /* Vertical Feature List on Right (One feature per row) */
    .v-feature-list {
      margin-top: 36px;
      display: grid;
      gap: 28px;
    }
    
    .v-feature-item {
      display: flex;
      gap: 20px;
      align-items: flex-start;
    }
    
    .v-feature-num {
      font-family: var(--serif);
      font-size: 18px;
      color: var(--violet);
      font-weight: 600;
      line-height: 1.2;
      border-bottom: 1px solid var(--sand);
      padding-bottom: 2px;
    }
    
    .v-feature-content h4 {
      margin-bottom: 4px;
    }
    
    .v-feature-content p {
      line-height: 1.5;
    }
    
    @media (max-width: 900px) {
      .video-showcase {
        padding: 60px 24px;
      }
      .video-showcase-inner {
        grid-template-columns: 1fr;
        gap: 40px;
      }
      .video-showcase-right {
        text-align: left;
      }
      .v-feature-list {
        margin-top: 32px;
      }
    }

    /* ── TESTIMONIALS ── */
    .testimonials {
      background: var(--white);
    }

    .testimonials-inner {
      max-width: 1100px;
      margin: 0 auto;
    }

    .testimonials-head {
      text-align: center;
      margin-bottom: 72px;
    }

    .testimonials-head .section-desc {
      margin: 0 auto;
    }

    .testimonial-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 32px;
    }

    .testimonial {
      background: var(--cream);
      padding: 48px 40px;
      border-radius: 2px;
      transition: var(--transition);
      display: flex;
      flex-direction: column;
    }

    .testimonial:hover {
      transform: translateY(-4px);
      background: var(--warm);
    }

    .t-rating {
      color: var(--violet);
      font-size: 12px;
      letter-spacing: 2px;
      margin-bottom: 24px;
    }

    .t-text {
      font-family: var(--serif);
      font-size: 20px;
      font-style: italic;
      font-weight: 400;
      color: var(--ink);
      line-height: 1.6;
      margin-bottom: 32px;
      flex-grow: 1;
    }

    .t-author {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .t-avatar {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background-size: cover;
      background-position: center;
      border: 1px solid var(--sand);
    }

    .t-meta {
      display: flex;
      flex-direction: column;
    }

    .t-name {
      font-family: var(--sans);
      font-size: 14px;
      font-weight: 500;
      color: var(--ink);
    }

    .t-role {
      font-size: 12px;
      color: var(--bark);
      font-weight: 400;
    }

    /* ── PRICING ── */
    .pricing {
      background: var(--ink);
    }

    .pricing .section-label {
      color: var(--violet-l);
    }

    .pricing .section-title {
      color: var(--white);
    }

    .pricing .section-title em {
      color: var(--violet-l);
    }

    .pricing-inner {
      max-width: 1000px;
      margin: 0 auto;
    }

    .pricing-head {
      text-align: center;
      margin-bottom: 64px;
    }

    .pricing-head .section-desc {
      color: var(--stone);
      margin: 0 auto;
    }

    .plans {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 2px;
    }

    .plan {
      background: #2A2420;
      padding: 48px 36px;
      position: relative;
      transition: background var(--transition);
    }

    .plan:hover {
      background: #332C28;
    }

    .plan.featured {
      background: var(--violet);
      transform: translateY(-8px);
    }

    .plan.featured:hover {
      background: var(--violet-d);
    }

    .plan-badge {
      display: inline-block;
      background: var(--violet-l);
      color: var(--violet-d);
      font-size: 10px;
      font-weight: 500;
      letter-spacing: 2px;
      text-transform: uppercase;
      padding: 4px 12px;
      border-radius: 2px;
      margin-bottom: 24px;
    }

    .plan.featured .plan-badge {
      background: rgba(255, 255, 255, 0.2);
      color: var(--white);
    }

    .plan-name {
      font-family: var(--serif);
      font-size: 28px;
      font-weight: 500;
      color: var(--white);
      margin-bottom: 8px;
    }

    .plan-price {
      font-family: var(--serif);
      font-size: 52px;
      font-weight: 500;
      color: var(--white);
      line-height: 1;
      margin-bottom: 4px;
    }

    .plan-price sup {
      font-size: 22px;
      vertical-align: super;
      font-weight: 400;
    }

    .plan-period {
      font-size: 13px;
      color: var(--sand);
      margin-bottom: 32px;
    }

    .plan.featured .plan-period {
      color: rgba(255, 255, 255, 0.6);
    }

    .plan-divider {
      height: 1px;
      background: rgba(255, 255, 255, 0.1);
      margin-bottom: 28px;
    }

    .plan-features {
      list-style: none;
      margin-bottom: 36px;
    }

    .plan-features li {
      font-size: 14px;
      font-weight: 400;
      color: rgba(255, 255, 255, 0.85);
      padding: 8px 0;
      border-bottom: 1px solid rgba(255, 255, 255, 0.06);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .plan-features li::before {
      content: '—';
      color: var(--violet-l);
      font-weight: 500;
      flex-shrink: 0;
    }

    .plan.featured .plan-features li::before {
      color: rgba(255, 255, 255, 0.5);
    }

    .plan-cta {
      display: block;
      text-align: center;
      padding: 14px 24px;
      font-size: 12px;
      font-weight: 500;
      letter-spacing: 2px;
      text-transform: uppercase;
      text-decoration: none;
      border-radius: 2px;
      transition: all var(--transition);
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: var(--white);
    }

    .plan-cta:hover {
      border-color: var(--white);
    }

    .plan.featured .plan-cta {
      background: var(--white);
      color: var(--violet-d);
      border-color: var(--white);
    }

    .plan.featured .plan-cta:hover {
      background: var(--cream);
    }

    /* ── BRAND SYSTEM ── */
    .brand {
      background: var(--warm);
    }

    .brand-inner {
      max-width: 1100px;
      margin: 0 auto;
    }

    .brand-head {
      margin-bottom: 56px;
    }

    .brand-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 48px;
    }

    .brand-block h4 {
      font-size: 11px;
      font-weight: 500;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: var(--stone);
      margin-bottom: 24px;
    }

    .palette {
      display: flex;
      gap: 8px;
    }

    .swatch {
      flex: 1;
      height: 64px;
      border-radius: 2px;
      position: relative;
    }

    .swatch span {
      position: absolute;
      bottom: -22px;
      left: 0;
      font-size: 11px;
      color: var(--stone);
      white-space: nowrap;
    }

    .font-sample {
      margin-bottom: 20px;
    }

    .font-sample .fs-name {
      font-size: 11px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--stone);
      margin-bottom: 8px;
    }

    .font-sample .fs-display {
      font-family: var(--serif);
      font-size: 40px;
      font-weight: 500;
      color: var(--ink);
      line-height: 1.1;
    }

    .font-sample .fs-body {
      font-family: var(--sans);
      font-size: 16px;
      font-weight: 400;
      color: var(--bark);
      margin-top: 8px;
    }

    /* ── CTA ── */
    .cta-section {
      background: var(--cream);
      text-align: center;
      padding: 120px 48px;
    }

    .cta-section .section-title {
      max-width: 600px;
      margin: 0 auto 16px;
    }

    .cta-section .section-desc {
      margin: 0 auto 48px;
      text-align: center;
    }

    /* ── ANIMATIONS ── */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(24px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-up {
      animation: fadeUp 0.8s ease forwards;
    }

    .delay-1 {
      animation-delay: 0.1s;
      opacity: 0;
    }

    .delay-2 {
      animation-delay: 0.25s;
      opacity: 0;
    }

    .delay-3 {
      animation-delay: 0.4s;
      opacity: 0;
    }

    .delay-4 {
      animation-delay: 0.55s;
      opacity: 0;
    }

    /* ── TEMPLATES PREVIEW ── */
    .templates-preview {
      background: var(--white);
    }

    .templates-inner {
      max-width: 1100px;
      margin: 0 auto;
    }

    .templates-head {
      text-align: center;
      margin-bottom: 72px;
    }

    .templates-head .section-desc {
      margin: 0 auto;
    }

    .t-preview-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 32px;
    }

    .t-preview-card {
      background: var(--cream);
      border-radius: 2px;
      overflow: hidden;
      transition: var(--transition);
      border: 1px solid transparent;
    }

    .t-preview-card:hover {
      transform: translateY(-8px);
      border-color: var(--sand);
      background: var(--warm);
    }

    @keyframes autoScrollLanding {

      0%,
      8% {
        transform: translateY(0);
      }

      45%,
      55% {
        transform: translateY(calc(-100% + 320px));
      }

      92%,
      100% {
        transform: translateY(0);
      }
    }

    .t-preview-img {
      height: 320px;
      overflow: hidden;
      position: relative;
      background-color: var(--sand);
    }

    .t-preview-img img {
      width: 100%;
      height: auto;
      position: absolute;
      top: 0;
      left: 0;
      animation: autoScrollLanding 16s ease-in-out infinite;
    }

    .t-preview-card:hover .t-preview-img img {
      animation-play-state: paused;
    }

    .t-preview-info {
      padding: 32px;
    }

    .t-preview-tag {
      font-size: 10px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--violet);
      font-weight: 500;
      margin-bottom: 12px;
      display: block;
    }

    .t-preview-info h3 {
      margin-bottom: 8px;
    }

    .t-preview-info p {
      margin-bottom: 24px;
      line-height: 1.6;
    }

    .t-preview-link {
      font-size: 11px;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: var(--ink);
      text-decoration: none;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: gap 0.3s ease;
    }

    .t-preview-link:hover {
      gap: 12px;
      color: var(--violet);
    }

    .t-preview-link span {
      font-size: 16px;
    }

    /* ── FAQ SECTION ── */
    .faq {
      background: var(--warm);
    }

    .faq-inner {
      max-width: 800px;
      margin: 0 auto;
    }

    .faq-head {
      text-align: center;
      margin-bottom: 56px;
    }

    .faq-head .section-desc {
      margin: 0 auto;
    }

    .faq-list {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .faq-item {
      background: var(--white);
      border: 1px solid var(--sand);
      border-radius: 2px;
      overflow: hidden;
      transition: var(--transition);
    }

    .faq-item.active {
      border-color: var(--violet);
      box-shadow: 0 10px 30px rgba(124, 92, 138, 0.04);
    }

    .faq-question {
      width: 100%;
      padding: 24px 32px;
      background: none;
      border: none;
      text-align: left;
      display: flex;
      justify-content: space-between;
      align-items: center;
      cursor: pointer;
    }

    .faq-toggle-icon {
      font-size: 18px;
      color: var(--stone);
      transition: transform 0.3s ease;
      font-family: var(--sans);
      line-height: 1;
    }

    .faq-item.active .faq-toggle-icon {
      transform: rotate(45deg);
      color: var(--violet);
    }

    .faq-answer {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }

    .faq-answer-content {
      padding: 0 32px 24px;
    }

    @media (max-width: 900px) {
      section {
        padding: 60px 24px;
      }

      .hero {
        padding: 100px 24px 60px;
      }

      .hero-sub {
        margin-bottom: 32px;
      }

      .steps {
        grid-template-columns: 1fr;
        gap: 16px;
      }

      .step-connector {
        display: none;
      }

      .features-grid {
        grid-template-columns: 1fr;
        gap: 16px;
      }

      .testimonial-grid {
        grid-template-columns: 1fr;
        gap: 24px;
      }

      .plans {
        grid-template-columns: 1fr;
        gap: 24px;
      }

      .plan.featured {
        transform: none;
      }

      .brand-grid {
        grid-template-columns: 1fr;
      }

      .t-preview-grid {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 600px) {
      .hero h1 {
        font-size: 52px;
      }

      .hero-brands {
        gap: 20px;
      }

      .hero-brands span {
        font-size: 14px;
      }

      .palette {
        flex-wrap: wrap;
      }

      .swatch {
        flex: 1 1 30%;
        height: 50px;
      }

      .faq-question {
        padding: 20px 24px;
        font-size: 17px;
      }

      .faq-answer-content {
        padding: 0 24px 20px;
      }
    }
  </style>
@endsection

@section('content')
  <!-- HERO -->
  <section class="hero">
    <p class="hero-eyebrow fade-up">Perfume Platform</p>
    <h1 class="fade-up delay-1">Your scent brand,<br /><em>live today.</em></h1>
    <p class="hero-sub fade-up delay-2">Vespr gives independent perfumers and fragrance houses everything they need to
      sell online — beautiful store, smart tools, zero complexity.</p>
    <div class="hero-actions fade-up delay-3">
      <a href="#onboarding" class="btn-primary">Start for free</a>
      <a href="#features" class="btn-ghost">See features</a>
    </div>
    <p class="hero-trust fade-up delay-4">Trusted by</p>
    <div class="hero-brands fade-up delay-4">
      <span>Maison L'Amour</span>
      <span>Scent & Soul</span>
      <span>Thorne</span>
      <span>Nurah</span>
    </div>
  </section>

  <!-- ONBOARDING -->
  <section class="onboarding" id="onboarding">
    <div class="onboarding-inner">
      <div class="onboarding-head">
        <p class="section-label">How it works</p>
        <h2 class="section-title">Up and selling in<br /><em>four simple steps</em></h2>
        <p class="section-desc">No developers. No design agency. No complexity. Go from idea to live fragrance store in
          under an hour.</p>
      </div>
      <div class="steps">
        <div class="step">
          <div class="step-num">01</div>
          <div class="step-title">Create your account</div>
          <div class="step-desc">Sign up with your email. No credit card required to start. Your store is provisioned
            instantly.</div>
          <span class="step-tag">2 minutes</span>
          <div class="step-connector"></div>
        </div>
        <div class="step">
          <div class="step-num">02</div>
          <div class="step-title">Pick your theme</div>
          <div class="step-desc">Choose from our curated fragrance-first templates. Each one is designed to convert
            visitors into buyers.</div>
          <span class="step-tag">5 minutes</span>
          <div class="step-connector"></div>
        </div>
        <div class="step">
          <div class="step-num">03</div>
          <div class="step-title">Add your fragrances</div>
          <div class="step-desc">Upload your products, set prices, write your scent notes. Our editor makes it feel
            effortless.</div>
          <span class="step-tag">15 minutes</span>
          <div class="step-connector"></div>
        </div>
        <div class="step">
          <div class="step-num">04</div>
          <div class="step-title">Launch & sell</div>
          <div class="step-desc">Connect your domain, set up payments, and go live. Your fragrance store is open for
            business.</div>
          <span class="step-tag">Today</span>
        </div>
      </div>
    </div>
  </section>

  <!-- FEATURES -->
  <section class="features" id="features">
    <div class="features-inner">
      <div class="features-head">
        <p class="section-label">Platform features</p>
        <h2 class="section-title">Everything a fragrance<br /><em>brand needs</em></h2>
        <p class="section-desc">Meticulously engineered tools to convey the sensory details, brand legacy, and visual
          beauty of your scent collections.</p>
      </div>

      <div class="features-showcase">
        <!-- Left Side: Interactive Tabs -->
        <div class="features-tabs">
          <button class="feature-tab active" data-tab="themes">
            <span class="tab-icon">◈</span>
            <span class="tab-label">Couture Themes</span>
          </button>
          <button class="feature-tab" data-tab="bundling">
            <span class="tab-icon">◎</span>
            <span class="tab-label">Scent Bundling</span>
          </button>
          <button class="feature-tab" data-tab="multibrand">
            <span class="tab-icon">⊞</span>
            <span class="tab-label">Multi-Brand Hub</span>
          </button>
          <button class="feature-tab" data-tab="performance">
            <span class="tab-icon">◐</span>
            <span class="tab-label">Velvet Speed</span>
          </button>
          <button class="feature-tab" data-tab="seo">
            <span class="tab-icon">◉</span>
            <span class="tab-label">Discovery SEO</span>
          </button>
          <button class="feature-tab" data-tab="payments">
            <span class="tab-icon">◇</span>
            <span class="tab-label">Secure Checkout</span>
          </button>
        </div>

        <!-- Right Side: Browser Mockup Showcase -->
        <div class="features-preview">
          <div class="browser-header">
            <div class="browser-dots">
              <div class="browser-dot" style="background: #FF5F56;"></div>
              <div class="browser-dot" style="background: #FFBD2E;"></div>
              <div class="browser-dot" style="background: #27C93F;"></div>
            </div>
            <div class="browser-title">vespr.store // brand_manager</div>
            <div class="browser-actions">
              <div class="browser-btn-dummy"></div>
              <div class="browser-btn-dummy"></div>
            </div>
          </div>

          <div class="browser-content">
            <!-- Couture Themes Tab Content -->
            <div class="tab-content active" id="tab-themes">
              <div class="tab-slideshow" id="themes-slideshow">
                <div class="slide active">
                  <img src="{{ asset('Images/landing/v3-template.png') }}" alt="Aura Theme" class="tab-content-img" style="object-fit: contain; background: var(--white);">
                </div>
                <div class="slide">
                  <img src="{{ asset('Images/landing/v2-template.png') }}" alt="Velvet Theme" class="tab-content-img" style="object-fit: contain; background: var(--white);">
                </div>
                <div class="slide">
                  <img src="{{ asset('Images/landing/v4-template.png') }}" alt="Heritage Theme" class="tab-content-img" style="object-fit: contain; background: var(--white);">
                </div>
                <div class="slide">
                  <img src="{{ asset('Images/landing/v1-template.png') }}" alt="Classic Theme" class="tab-content-img" style="object-fit: contain; background: var(--white);">
                </div>
                
                <!-- Controls -->
                <div class="slide-controls">
                  <button type="button" class="slide-nav-btn prev-slide" aria-label="Previous Slide">←</button>
                  <div class="slide-dots">
                    <span class="slide-dot active" data-slide="0"></span>
                    <span class="slide-dot" data-slide="1"></span>
                    <span class="slide-dot" data-slide="2"></span>
                    <span class="slide-dot" data-slide="3"></span>
                  </div>
                  <button type="button" class="slide-nav-btn next-slide" aria-label="Next Slide">→</button>
                </div>
              </div>
              
              <div class="tab-content-overlay" style="z-index: 10;">
                <h3 class="tab-content-title">Couture Storefront Themes</h3>
                <p class="tab-content-desc">Switch between world-class fragrance-specific designs with a single click. Every template is meticulously engineered to tell your brand’s olfactory story with premium elegance.</p>
              </div>
            </div>

            <!-- Scent Bundling Tab Content -->
            <div class="tab-content" id="tab-bundling">
              <div class="tab-slideshow">
                <div class="slide active">
                  <img src="{{ asset('Images/landing/bundle1.1.png') }}" alt="Scent Bundling - Step 1" class="tab-content-img" style="object-fit: contain; background: var(--white);">
                </div>
                <div class="slide">
                  <img src="{{ asset('Images/landing/bundle1.2.png') }}" alt="Scent Bundling - Step 2" class="tab-content-img" style="object-fit: contain; background: var(--white);">
                </div>
                
                <!-- Controls -->
                <div class="slide-controls">
                  <button type="button" class="slide-nav-btn prev-slide" aria-label="Previous Slide">←</button>
                  <div class="slide-dots">
                    <span class="slide-dot active" data-slide="0"></span>
                    <span class="slide-dot" data-slide="1"></span>
                  </div>
                  <button type="button" class="slide-nav-btn next-slide" aria-label="Next Slide">→</button>
                </div>
              </div>
              
              <div class="tab-content-overlay" style="z-index: 10;">
                <h3 class="tab-content-title">Intelligent Scent Bundles</h3>
                <p class="tab-content-desc">Maximize your average order value automatically. Combine complementary perfume sprays, solid balms, and travel vials into custom gift sets directly inside checkout.</p>
              </div>
            </div>

            <!-- Multi-Brand Hub Tab Content -->
            <div class="tab-content" id="tab-multibrand">
              <img src="{{ asset('Images/landing/dashboard.png') }}" alt="Multi-Brand Dashboard"
                class="tab-content-img" style="object-fit: contain; background: var(--white);">
              <div class="tab-content-overlay">
                <h3 class="tab-content-title">Multi-Brand House Dashboard</h3>
                <p class="tab-content-desc">Manage all of your custom fragrance labels, inventory logs, and product
                  collections from one central, unified administration dashboard. Perfect for multi-line ateliers.</p>
              </div>
            </div>

            <!-- Velvet Speed Tab Content -->
            <div class="tab-content" id="tab-performance">
              <img src="{{ asset('Images/landing/analytics.png') }}" alt="Velvet Performance" class="tab-content-img"
                style="object-fit: contain; background: var(--white);">
              <div class="tab-content-overlay">
                <h3 class="tab-content-title">Velvet Speed &amp; Analytics</h3>
                <p class="tab-content-desc">Lightning-fast store loading speeds built to maximize perfume conversions.
                  Every single millisecond is finely tuned to keep premium clientele engaged and buying.</p>
              </div>
            </div>

            <!-- Discovery SEO Tab Content -->
            <div class="tab-content" id="tab-seo">
              <img src="{{ asset('Images/landing/products.png') }}" alt="Discovery SEO" class="tab-content-img"
                style="object-fit: contain; background: var(--white);">
              <div class="tab-content-overlay">
                <h3 class="tab-content-title">Olfactory Search &amp; Discovery SEO</h3>
                <p class="tab-content-desc">Help potential clients find your specific scent profiles in organic search.
                  Auto-generates structural metadata matching scent notes, bottles, and ingredients.</p>
              </div>
            </div>

            <!-- Secure Checkout Tab Content -->
            <div class="tab-content" id="tab-payments">
              <img src="{{ asset('Images/landing/checkout.png') }}" alt="Secure Checkout" class="tab-content-img"
                style="object-fit: contain; background: var(--white);">
              <div class="tab-content-overlay">
                <h3 class="tab-content-title">Secure &amp; Elegant Checkout</h3>
                <p class="tab-content-desc">Fully secure, high-trust encrypted payment payment gateways built for
                  high-value conversions. Seamlessly integrates credit cards, Apple Pay, Stripe, and global gateways out
                  of the box.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- VIDEO SHOWCASE -->
  <section class="video-showcase" id="walkthrough">
    <div class="video-showcase-inner">
      <!-- Left: Sleek, compact browser mock frame with walkthrough video -->
      <div class="video-showcase-left">
        <div class="video-browser-frame">
          <div class="video-browser-header">
            <div class="video-browser-dots">
              <div class="video-browser-dot" style="background: #FF5F56;"></div>
              <div class="video-browser-dot" style="background: #FFBD2E;"></div>
              <div class="video-browser-dot" style="background: #27C93F;"></div>
            </div>
            <div class="video-browser-title">vespr.store /admin panel</div>
            <div style="width: 32px;"></div>
          </div>
          <div class="video-wrapper-inner" style="aspect-ratio: 1.8285714285714285;">
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

      <!-- Right: Structured vertical list of features (One per row) -->
      <div class="video-showcase-right">
        <p class="section-label" style="margin-bottom: 8px;">Conversion Engine</p>
        <h2 class="section-title" style="font-size: 2.2rem; line-height: 1.2; margin-bottom: 16px;">Built to bundle,<br /><em>designed to sell</em></h2>
        
        <div class="v-feature-list">
          <div class="v-feature-item">
            <div class="v-feature-num">01</div>
            <div class="v-feature-content">
              <h4>Olfactory Bundling Engine</h4>
              <p>Launch high-impact scent bundles pairing perfume extracts with custom travel sprays to increase order value.</p>
            </div>
          </div>
          <div class="v-feature-item">
            <div class="v-feature-num">02</div>
            <div class="v-feature-content">
              <h4>Olfactory Scent Profiler</h4>
              <p>Configure ingredients (top, heart, and base notes) centrally to guide discovery search filters.</p>
            </div>
          </div>
          <div class="v-feature-item">
            <div class="v-feature-num">03</div>
            <div class="v-feature-content">
              <h4>Unified Atelier Dashboard</h4>
              <p>Manage incoming orders, inventory counts, and multi-brand catalogs inside one high-speed workspace.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- TEMPLATES PREVIEW -->
  <section class="templates-preview" id="templates">
    <div class="templates-inner">
      <div class="templates-head">
        <p class="section-label">Exquisite Themes</p>
        <h2 class="section-title">Designed for high-conversion<br /><em>fragrance storytelling</em></h2>
        <p class="section-desc">Choose from our curated collection of luxury themes. Each one is meticulously crafted to
          reflect the heritage and nuance of your scent brand.</p>
      </div>
      <div class="t-preview-grid">
        <div class="t-preview-card">
          <div class="t-preview-img">
            <img src="{{ asset('Images/landing/v3-template.png') }}" alt="Aura Template">
          </div>
          <div class="t-preview-info">
            <span class="t-preview-tag">Editorial</span>
            <h3>Aura</h3>
            <p>The gold standard for modern fragrance houses. Centered elegance with high-impact product grids.</p>
            <a href="{{ route('landing.templates') }}" class="t-preview-link">View Details <span>→</span></a>
          </div>
        </div>
        <div class="t-preview-card">
          <div class="t-preview-img">
            <img src="{{ asset('Images/landing/v2-template.png') }}" alt="Velvet Template">
          </div>
          <div class="t-preview-info">
            <span class="t-preview-tag">Minimalist</span>
            <h3>Velvet</h3>
            <p>A sophisticated dark aesthetic for exclusive collections and boutique perfume ateliers.</p>
            <a href="{{ route('landing.templates') }}" class="t-preview-link">View Details <span>→</span></a>
          </div>
        </div>
      </div>
      <div style="text-align: center; margin-top: 64px;">
        <a href="{{ route('landing.templates') }}" class="btn-ghost">Explore all templates</a>
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section class="testimonials" id="testimonials">
    <div class="testimonials-inner">
      <div class="testimonials-head">
        <p class="section-label">Success stories</p>
        <h2 class="section-title">Loved by the world's<br /><em>finest noses</em></h2>
        <p class="section-desc">Join the community of independent perfumers and established heritage brands scaling their
          digital presence with Vespr.</p>
      </div>
      <div class="testimonial-grid">
        <div class="testimonial">
          <div class="t-rating">★★★★★</div>
          <p class="t-text">"Vespr understood the nuance of fragrance storytelling. Our online boutique now feels as
            premium as our physical atelier in Grasse."</p>
          <div class="t-author">
            <div class="t-avatar"
              style="background-image: url('https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop')">
            </div>
            <div class="t-meta">
              <span class="t-name">Marc-Antoine</span>
              <span class="t-role">Creative Director, Maison L'Amour</span>
            </div>
          </div>
        </div>
        <div class="testimonial">
          <div class="t-rating">★★★★★</div>
          <p class="t-text">"The scent bundling engine alone increased our average order value by 45%. It's the only
            platform that truly 'gets' the perfume business."</p>
          <div class="t-author">
            <div class="t-avatar"
              style="background-image: url('https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop')">
            </div>
            <div class="t-meta">
              <span class="t-name">Elena Rossi</span>
              <span class="t-role">Founder, Scent & Soul</span>
            </div>
          </div>
        </div>
        <div class="testimonial">
          <div class="t-rating">★★★★★</div>
          <p class="t-text">"We migrated from Shopify in a weekend. The themes are exquisite and the multi-brand dashboard
            is a game-changer for our group."</p>
          <div class="t-author">
            <div class="t-avatar"
              style="background-image: url('https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop')">
            </div>
            <div class="t-meta">
              <span class="t-name">James Thorne</span>
              <span class="t-role">CEO, Thorne Fragrance Group</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- PRICING -->
  <section class="pricing" id="pricing">
    <div class="pricing-inner">
      <div class="pricing-head">
        <p class="section-label">Pricing</p>
        <h2 class="section-title">Simple,<br /><em>transparent pricing</em></h2>
        <p class="section-desc">Start free. Upgrade when you grow. No hidden fees, no setup costs.</p>
      </div>
      <div class="plans">
        <div class="plan">
          <div class="plan-badge">Starter</div>
          <div class="plan-name">Boutique</div>
          <div class="plan-price"><sup>$</sup>10</div>
          <div class="plan-period">per month · billed monthly</div>
          <div class="plan-divider"></div>
          <ul class="plan-features">
            <li>Up to 50 fragrances</li>
            <li>Nurah Classic theme</li>
            <li>Inventory management</li>
            <li>Basic SEO tools</li>
            <li>Email support</li>
          </ul>
          <a href="#" class="plan-cta">Get started</a>
        </div>
        <div class="plan featured">
          <div class="plan-badge">Most popular</div>
          <div class="plan-name">Maison</div>
          <div class="plan-price"><sup>$</sup>20</div>
          <div class="plan-period">per month · billed monthly</div>
          <div class="plan-divider"></div>
          <ul class="plan-features">
            <li>Unlimited fragrances</li>
            <li>Full template library</li>
            <li>Scent combo engine</li>
            <li>Multi-brand dashboard</li>
            <li>Priority WhatsApp support</li>
          </ul>
          <a href="#" class="plan-cta">Get started</a>
        </div>
        <div class="plan">
          <div class="plan-badge">Enterprise</div>
          <div class="plan-name">Heritage</div>
          <div class="plan-price"><sup>$</sup>49</div>
          <div class="plan-period">per month · billed monthly</div>
          <div class="plan-divider"></div>
          <ul class="plan-features">
            <li>White-label experience</li>
            <li>Custom domain setup</li>
            <li>Dedicated brand partner</li>
            <li>Full API & webhook access</li>
            <li>Bespoke onboarding</li>
          </ul>
          <a href="#" class="plan-cta">Get started</a>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section class="faq" id="faq">
    <div class="faq-inner">
      <div class="faq-head">
        <p class="section-label">Common questions</p>
        <h2 class="section-title">Frequently asked<br /><em>inquiries</em></h2>
        <p class="section-desc">Everything you need to know about the VESPR platform, custom storefront templates, and how
          we help your brand scale.</p>
      </div>

      <div class="faq-list">
        <div class="faq-item">
          <button class="faq-question">
            <span>What is VESPR and how does it help my fragrance brand?</span>
            <span class="faq-toggle-icon">+</span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-content">
              VESPR is a high-performance eCommerce platform custom-tailored for independent perfumers and luxury
              fragrance houses. Unlike generic store builders, VESPR includes perfume-centric visual layouts, built-in
              notes classification (top, heart, and base notes), intelligent combo bundling, and optimized product grids
              to showcase your craft beautifully.
            </div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">
            <span>Can I use my own custom domain?</span>
            <span class="faq-toggle-icon">+</span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-content">
              Yes, absolutely! Connecting a custom domain (such as <code>yourbrand.com</code>) is supported on all premium
              plans. We also provide secure, automated SSL certificates for all connected domains at no extra cost.
            </div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">
            <span>How do intelligent scent bundles work?</span>
            <span class="faq-toggle-icon">+</span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-content">
              Our proprietary bundling engine allows you to pair complimentary perfumes (e.g., suggesting a woody eau de
              parfum alongside a fresh travel spray) to create curated collections or combos. This feature can be managed
              easily from your multi-brand dashboard and helps maximize average order value (AOV) by up to 45%.
            </div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">
            <span>Is there a transaction commission on my sales?</span>
            <span class="faq-toggle-icon">+</span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-content">
              No, VESPR does not take any commission fee on your sales. You keep 100% of your earnings minus standard
              transaction processing fees from your payment gateway (e.g., Stripe, PayPal).
            </div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">
            <span>How long does it take to go live with my store?</span>
            <span class="faq-toggle-icon">+</span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-content">
              You can have a fully working, beautiful storefront live on the same day! Our bulk catalog importers,
              pre-configured layouts, and automated onboarding mean you only need to select a theme, upload your product
              details, connect your payment gateway, and launch.
            </div>
          </div>
        </div>

        <!-- <div class="faq-item">
                          <button class="faq-question">
                            <span>Can I migrate my existing store from Shopify or WooCommerce?</span>
                            <span class="faq-toggle-icon">+</span>
                          </button>
                          <div class="faq-answer">
                            <div class="faq-answer-content">
                              Yes! We provide built-in migration tools that allow you to import your products, collections, pricing lists, and media assets using standard CSV formatting. If you require assistance, our support team is available on WhatsApp and email to help make the transition completely seamless.
                            </div>
                          </div>
                        </div> -->
      </div>
    </div>
  </section>

  <!-- BRAND SYSTEM -->
  <!-- <section class="brand" id="brand">
                    <div class="brand-inner">
                      <div class="brand-head">
                        <p class="section-label">Brand system</p>
                        <h2 class="section-title">Colour palette &<br /><em>typography</em></h2>
                      </div>
                      <div class="brand-grid">
                        <div class="brand-block">
                          <h4>Neutral colour palette</h4>
                          <div class="palette" style="margin-bottom: 36px;">
                            <div class="swatch" style="background:#F5F0E8; border: 1px solid #D4C9B0;"><span>Cream</span></div>
                            <div class="swatch" style="background:#EDE6D6;"><span>Warm</span></div>
                            <div class="swatch" style="background:#D4C9B0;"><span>Sand</span></div>
                            <div class="swatch" style="background:#9C9080;"><span>Stone</span></div>
                            <div class="swatch" style="background:#5C5147;"><span>Bark</span></div>
                            <div class="swatch" style="background:#1E1A16;"><span>Ink</span></div>
                            <div class="swatch" style="background:#7C5C8A;"><span>Violet</span></div>
                          </div>
                          <h4 style="margin-top: 48px;">Usage</h4>
                          <div style="display:grid; gap:8px; margin-top:12px;">
                            <div style="display:flex; align-items:center; gap:12px; font-size:13px; color: var(--bark);">
                              <div
                                style="width:16px; height:16px; background:#F5F0E8; border:1px solid #D4C9B0; border-radius:2px; flex-shrink:0;">
                              </div>
                              Cream — page backgrounds
                            </div>
                            <div style="display:flex; align-items:center; gap:12px; font-size:13px; color: var(--bark);">
                              <div style="width:16px; height:16px; background:#D4C9B0; border-radius:2px; flex-shrink:0;"></div>
                              Sand — borders, dividers
                            </div>
                            <div style="display:flex; align-items:center; gap:12px; font-size:13px; color: var(--bark);">
                              <div style="width:16px; height:16px; background:#9C9080; border-radius:2px; flex-shrink:0;"></div>
                              Stone — body text, secondary
                            </div>
                            <div style="display:flex; align-items:center; gap:12px; font-size:13px; color: var(--bark);">
                              <div style="width:16px; height:16px; background:#1E1A16; border-radius:2px; flex-shrink:0;"></div>
                              Ink — headings, CTAs
                            </div>
                            <div style="display:flex; align-items:center; gap:12px; font-size:13px; color: var(--bark);">
                              <div style="width:16px; height:16px; background:#7C5C8A; border-radius:2px; flex-shrink:0;"></div>
                              Violet — accents, highlights
                            </div>
                          </div>
                        </div>
                        <div class="brand-block">
                          <h4>Font pairing</h4>
                          <div class="font-sample">
                            <div class="fs-name">Display — Cormorant Garamond</div>
                            <div class="fs-display">The Art of Scent</div>
                            <div style="font-size:12px; color:var(--stone); margin-top:6px; font-weight:300;">Light 300 · Italic for
                              emphasis · Headlines &amp; hero text</div>
                          </div>
                          <div style="height:1px; background: var(--sand); margin: 24px 0;"></div>
                          <div class="font-sample">
                            <div class="fs-name">Body — DM Sans</div>
                            <div class="fs-body">Sell fragrance, effortlessly. Built for independent perfumers and luxury fragrance
                              houses.</div>
                            <div style="font-size:12px; color:var(--stone); margin-top:6px; font-weight:300;">Light 300 · Regular 400 ·
                              UI, navigation, body copy</div>
                          </div>
                          <div style="height:1px; background: var(--sand); margin: 24px 0;"></div>
                          <div style="font-size:12px; color:var(--stone); font-weight:300; line-height:1.8;">
                            <strong style="font-weight:500; color:var(--bark);">Why this pairing:</strong> Cormorant brings old-world
                            fragrance house elegance. DM Sans keeps the SaaS UI clean and readable. The contrast between serif display and
                            geometric sans signals both luxury and modern simplicity.
                          </div>
                        </div>
                      </div>
                    </div>
                  </section> -->

  <!-- CTA -->
  <section class="cta-section">
    <p class="section-label">Get started</p>
    <h2 class="section-title">Ready to launch your<br /><em>fragrance brand?</em></h2>
    <p class="section-desc">Join the fragrance houses using Vespr to power their digital presence. No setup fee. No
      developer needed.</p>
    <div class="hero-actions">
      <a href="#pricing" class="btn-primary">Start for free</a>
      <a href="https://wa.me/your-number" class="btn-ghost">Chat on WhatsApp</a>
    </div>
  </section>
@endsection

@section('scripts')
  <script src="https://fast.wistia.com/player.js" async></script>
  <script src="https://fast.wistia.com/embed/0dhesptrqu.js" async type="module"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // FAQ Accordion Logic
      const faqQuestions = document.querySelectorAll('.faq-question');
      faqQuestions.forEach(q => {
        q.addEventListener('click', () => {
          const item = q.parentElement;
          const answer = item.querySelector('.faq-answer');
          const isActive = item.classList.contains('active');

          // Close other active items
          document.querySelectorAll('.faq-item').forEach(i => {
            if (i !== item) {
              i.classList.remove('active');
              i.querySelector('.faq-answer').style.maxHeight = null;
            }
          });

          if (!isActive) {
            item.classList.add('active');
            answer.style.maxHeight = answer.scrollHeight + 'px';
          } else {
            item.classList.remove('active');
            answer.style.maxHeight = null;
          }
        });
      });

      // Interactive Features Tabs Logic
      const featureTabs = document.querySelectorAll('.feature-tab');
      const tabContents = document.querySelectorAll('.tab-content');

      featureTabs.forEach(tab => {
        tab.addEventListener('click', () => {
          const targetTab = tab.getAttribute('data-tab');

          // Deactivate all tabs and contents
          featureTabs.forEach(t => t.classList.remove('active'));
          tabContents.forEach(c => c.classList.remove('active'));

          // Activate selected tab and target content
          tab.classList.add('active');
          const activeContent = document.getElementById(`tab-${targetTab}`);
          if (activeContent) {
            activeContent.classList.add('active');
          }
        });
      });
      // Reusable Slideshow Initializer
      const initSlideshow = (selector) => {
        const slideshow = document.querySelector(selector);
        if (!slideshow) return;

        const slides = slideshow.querySelectorAll('.slide');
        const dots = slideshow.querySelectorAll('.slide-dot');
        const prevBtn = slideshow.querySelector('.prev-slide');
        const nextBtn = slideshow.querySelector('.next-slide');
        let currentSlide = 0;
        let slideInterval;

        const showSlide = (index) => {
          slides.forEach(s => s.classList.remove('active'));
          dots.forEach(d => d.classList.remove('active'));

          currentSlide = (index + slides.length) % slides.length;
          slides[currentSlide].classList.add('active');
          dots[currentSlide].classList.add('active');
        };

        const nextSlide = () => showSlide(currentSlide + 1);
        const prevSlide = () => showSlide(currentSlide - 1);

        const startAutoplay = () => {
          stopAutoplay();
          slideInterval = setInterval(nextSlide, 5000); // 5 seconds interval
        };

        const stopAutoplay = () => {
          if (slideInterval) clearInterval(slideInterval);
        };

        if (prevBtn) {
          prevBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            prevSlide();
            startAutoplay();
          });
        }

        if (nextBtn) {
          nextBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            nextSlide();
            startAutoplay();
          });
        }

        dots.forEach(dot => {
          dot.addEventListener('click', (e) => {
            e.stopPropagation();
            const index = parseInt(dot.getAttribute('data-slide'));
            showSlide(index);
            startAutoplay();
          });
        });

        startAutoplay();
        slideshow.addEventListener('mouseenter', stopAutoplay);
        slideshow.addEventListener('mouseleave', startAutoplay);
      };

      // Initialize both active feature slideshows
      initSlideshow('#themes-slideshow');
      initSlideshow('#tab-bundling .tab-slideshow');
    });
  </script>
@endsection