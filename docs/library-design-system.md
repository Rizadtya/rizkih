# Perpustakaan Sekolah Digital - Design System

**Version**: 1.0.0  
**Theme**: Newsprint (Editorial)  
**Generated**: 2026-08-12  
**Context**: School Library Management System

---

## Design Philosophy

This design system is built for a **school library management tool** — not a consumer app, not a SaaS dashboard, not a social platform. It should feel:

- **Editorial**: Like a well-designed reference book or journal
- **Trustworthy**: Appropriate for an educational institution
- **Intelligent**: Professional without being corporate
- **Restrained**: Purposeful, not flashy
- **Distinctive**: Clearly NOT a generic AI-generated template

### What We Avoid

❌ **Purple/blue AI gradients**  
❌ **Excessive glassmorphism**  
❌ **Rounded cards everywhere**  
❌ **Multiple shadow layers**  
❌ **Decorative blobs without function**  
❌ **Excessive glow effects**  
❌ **Attention-grabbing pulses**  
❌ **Infinite animations**  
❌ **Generic SaaS hero sections**

### What We Embrace

✅ **Typography-led hierarchy**  
✅ **Generous whitespace**  
✅ **Subtle borders over heavy shadows**  
✅ **Purposeful color with restraint**  
✅ **Clear information architecture**  
✅ **Accessible, readable interfaces**  
✅ **Consistent, predictable patterns**

---

## Typography

### Font Stack

**Display/Headings**: `Instrument Serif`
- Refined serif with educational gravitas
- Use for page titles, section headings, dashboard metrics
- Weights: 400 (regular), 500 (medium), 600 (semibold)

**Body/UI**: `Instrument Sans`
- Clean, readable sans-serif
- Use for body text, buttons, forms, navigation, tables
- Weights: 400 (regular), 500 (medium), 600 (semibold)

**Code/Data**: `IBM Plex Mono`
- For book codes, transaction IDs, technical data
- Weight: 400 (regular)

### Type Scale

```
--text-xs: 0.75rem (12px)   - metadata, captions
--text-sm: 0.875rem (14px)  - secondary text, labels
--text-base: 1rem (16px)    - body text, forms
--text-lg: 1.125rem (18px)  - emphasized body
--text-xl: 1.25rem (20px)   - small headings
--text-2xl: 1.5rem (24px)   - section headings
--text-3xl: 1.875rem (30px) - page titles
--text-4xl: 2.25rem (36px)  - dashboard headers
--text-display: 3rem (48px) - hero/welcome screens
```

### Usage Guidelines

**Page Titles**: Use `--text-3xl` or `--text-4xl` with `--font-display`
```css
h1 {
  font-family: var(--font-display);
  font-size: var(--text-3xl);
  font-weight: var(--font-weight-semibold);
  line-height: var(--leading-tight);
}
```

**Section Headings**: Use `--text-2xl` with `--font-display`
```css
h2 {
  font-family: var(--font-display);
  font-size: var(--text-2xl);
  font-weight: var(--font-weight-medium);
  line-height: var(--leading-snug);
}
```

**Body Text**: Use `--text-base` with `--font-body`
```css
p {
  font-family: var(--font-body);
  font-size: var(--text-base);
  line-height: var(--leading-normal);
  max-width: var(--measure-base);
}
```

**Small Text/Labels**: Use `--text-sm` with `--font-body`
```css
label, small {
  font-family: var(--font-body);
  font-size: var(--text-sm);
  font-weight: var(--font-weight-medium);
}
```

**Code/Data**: Use `--font-mono`
```css
code, .transaction-code, .book-code {
  font-family: var(--font-mono);
  font-size: var(--text-sm);
}
```

---

## Color Palette

### Core Colors (Light Mode)

**Paper (Backgrounds)**
- `--color-paper`: oklch(98% 0 0) - Main background
- `--color-paper-2`: oklch(96% 0 0) - Surface lift
- `--color-paper-3`: oklch(94% 0 0) - Hover states
- `--color-paper-4`: oklch(92% 0 0) - Borders

**Ink (Text)**
- `--color-ink`: oklch(25% 0 0) - Primary text
- `--color-ink-2`: oklch(45% 0 0) - Secondary text
- `--color-ink-3`: oklch(60% 0 0) - Muted text

**Accent - Library Sienna**
- `--color-accent`: oklch(52% 0.12 35) - Primary accent
- `--color-accent-hover`: oklch(48% 0.14 35) - Hover state
- `--color-accent-subtle`: oklch(94% 0.02 35) - Tinted backgrounds

### Status Colors

**Success** (forest green)
- `--color-success`: oklch(58% 0.15 145)
- `--color-success-subtle`: oklch(94% 0.02 145)
- **When to use**: Successful operations, available books, active status

**Warning** (amber)
- `--color-warning`: oklch(68% 0.16 75)
- `--color-warning-subtle`: oklch(94% 0.02 75)
- **When to use**: Approaching due dates, pending actions

**Danger** (brick red)
- `--color-danger`: oklch(55% 0.18 25)
- `--color-danger-subtle`: oklch(94% 0.02 25)
- **When to use**: Overdue books, errors, destructive actions

**Info** (muted blue)
- `--color-info`: oklch(60% 0.14 250)
- `--color-info-subtle`: oklch(94% 0.02 250)
- **When to use**: Informational messages, book categories

### Color Usage Rules

1. **Use semantic color variables, never raw values**
   ```css
   /* ✅ Correct */
   color: var(--color-ink);
   background: var(--color-paper-2);
   
   /* ❌ Wrong */
   color: oklch(25% 0 0);
   background: #f5f5f5;
   ```

2. **Limit accent color usage**
   - Primary buttons
   - Links
   - Active navigation states
   - Focus indicators
   - NOT for decorative elements

3. **Status colors are functional, not decorative**
   - Use sparingly
   - Always pair with text/icon for accessibility
   - Never use purely for visual interest

4. **Maintain contrast ratios**
   - Text on background: minimum 4.5:1 (WCAG AA)
   - Large text: minimum 3:1
   - Interactive elements: minimum 3:1

---

## Spacing

### Scale (4pt base)

```
--space-1: 0.25rem (4px)
--space-2: 0.5rem (8px)
--space-3: 0.75rem (12px)
--space-4: 1rem (16px)
--space-5: 1.25rem (20px)
--space-6: 1.5rem (24px)
--space-8: 2rem (32px)
--space-10: 2.5rem (40px)
--space-12: 3rem (48px)
--space-16: 4rem (64px)
--space-20: 5rem (80px)
--space-24: 6rem (96px)
```

### Semantic Spacing

```
--space-page-x: var(--space-6)       - Horizontal page padding
--space-page-y: var(--space-8)       - Vertical page padding
--space-section: var(--space-12)     - Between major sections
--space-card-inner: var(--space-6)   - Inside cards
--space-stack-tight: var(--space-2)  - Label → input
--space-stack-normal: var(--space-4) - Between form fields
--space-stack-loose: var(--space-6)  - Between content blocks
```

### Usage Guidelines

**Component Padding**: Use multiples of 4px
```css
/* Small: 12px (--space-3) */
/* Medium: 16px (--space-4) */
/* Large: 24px (--space-6) */
```

**Vertical Rhythm**: Stack elements consistently
```css
.form-field + .form-field {
  margin-top: var(--space-stack-normal);
}

section + section {
  margin-top: var(--space-section);
}
```

---

## Layout Principles

### Grid System

**Desktop**: 12-column CSS Grid
```css
.main-grid {
  display: grid;
  grid-template-columns: repeat(12, 1fr);
  gap: var(--space-6);
  max-width: var(--container-xl);
  margin: 0 auto;
}
```

**Sidebar Layout**
```css
.app-layout {
  display: grid;
  grid-template-columns: var(--sidebar-width) 1fr;
}

@media (max-width: 768px) {
  .app-layout {
    grid-template-columns: 1fr;
  }
}
```

### Breakpoints

```
--bp-sm: 640px   - Small mobile adjustments
--bp-md: 768px   - Tablet, sidebar appears
--bp-lg: 1024px  - Full desktop
--bp-xl: 1280px  - Max content width
```

### Container Max Widths

```
--container-sm: 640px
--container-md: 768px
--container-lg: 1024px
--container-xl: 1280px
```

---

## Components

### Buttons

**Primary** (High emphasis)
```css
.btn-primary {
  background: var(--color-accent);
  color: var(--color-paper);
  border: none;
  border-radius: var(--radius-sm);
  padding: var(--space-3) var(--space-6);
  font-family: var(--font-body);
  font-size: var(--text-base);
  font-weight: var(--font-weight-medium);
  cursor: pointer;
  transition: var(--transition-colors), var(--transition-transform);
}

.btn-primary:hover {
  background: var(--color-accent-hover);
}

.btn-primary:active {
  transform: translateY(1px);
}

.btn-primary:focus-visible {
  outline: var(--focus-ring-width) solid var(--color-focus);
  outline-offset: var(--focus-ring-offset);
}

.btn-primary:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
```

**Secondary** (Medium emphasis)
```css
.btn-secondary {
  background: transparent;
  color: var(--color-ink);
  border: 1px solid var(--color-border-emphasis);
  /* Rest same as primary */
}

.btn-secondary:hover {
  background: var(--color-paper-3);
}
```

**Tertiary** (Low emphasis)
```css
.btn-tertiary {
  background: transparent;
  color: var(--color-accent);
  border: none;
  text-decoration: underline;
  text-underline-offset: 2px;
}
```

**Destructive**
```css
.btn-danger {
  background: var(--color-danger);
  color: var(--color-paper);
  /* Rest same as primary */
}
```

### Forms

**Input/Textarea/Select**
```css
.form-control {
  background: var(--color-paper);
  border: 1px solid var(--color-border);
  border-radius: var(--radius-sm);
  padding: var(--space-3) var(--space-4);
  font-family: var(--font-body);
  font-size: var(--text-base);
  color: var(--color-ink);
  width: 100%;
  transition: var(--transition-colors), var(--transition-shadow);
}

.form-control:hover {
  border-color: var(--color-border-emphasis);
}

.form-control:focus {
  border-color: var(--color-accent);
  box-shadow: var(--shadow-focus);
  outline: none;
}

.form-control:disabled {
  background: var(--color-paper-2);
  color: var(--color-ink-3);
  cursor: not-allowed;
}

.form-control.error {
  border-color: var(--color-danger);
}
```

**Labels**
```css
.form-label {
  display: block;
  font-size: var(--text-sm);
  font-weight: var(--font-weight-medium);
  color: var(--color-ink);
  margin-bottom: var(--space-stack-tight);
}
```

**Helper Text**
```css
.form-helper {
  display: block;
  font-size: var(--text-xs);
  color: var(--color-ink-2);
  margin-top: var(--space-2);
}

.form-error {
  display: block;
  font-size: var(--text-xs);
  color: var(--color-danger);
  margin-top: var(--space-2);
}
```

### Cards

**Standard Card** (NO gradients, subtle borders)
```css
.card {
  background: var(--color-paper);
  border: 1px solid var(--color-border);
  border-radius: var(--radius-md);
  padding: var(--space-card-inner);
  transition: var(--transition-colors), var(--transition-shadow);
}

.card-interactive:hover {
  border-color: var(--color-border-emphasis);
  box-shadow: var(--shadow-sm);
}

.card-header {
  border-bottom: 1px solid var(--color-border);
  padding-bottom: var(--space-4);
  margin-bottom: var(--space-4);
}

.card-title {
  font-family: var(--font-display);
  font-size: var(--text-xl);
  font-weight: var(--font-weight-semibold);
  color: var(--color-ink);
  margin: 0;
}
```

**Stat Card** (Dashboard metrics, NO gradients)
```css
.stat-card {
  background: var(--color-paper);
  border: 1px solid var(--color-border);
  border-left: 3px solid var(--color-accent); /* Optional accent bar */
  border-radius: var(--radius-md);
  padding: var(--space-6);
}

.stat-value {
  font-family: var(--font-display);
  font-size: var(--text-4xl);
  font-weight: var(--font-weight-semibold);
  color: var(--color-ink);
  margin-bottom: var(--space-2);
}

.stat-label {
  font-size: var(--text-sm);
  color: var(--color-ink-2);
  text-transform: uppercase;
  letter-spacing: var(--tracking-wider);
}
```

### Tables

**Restrained, scannable design**
```css
.table-container {
  border: 1px solid var(--color-border);
  border-radius: var(--radius-md);
  overflow: hidden;
}

table {
  width: 100%;
  border-collapse: collapse;
}

thead {
  background: var(--color-paper-2);
  border-bottom: 2px solid var(--color-border-emphasis);
}

th {
  padding: var(--space-3) var(--space-4);
  text-align: left;
  font-size: var(--text-xs);
  font-weight: var(--font-weight-semibold);
  color: var(--color-ink-2);
  text-transform: uppercase;
  letter-spacing: var(--tracking-wider);
}

td {
  padding: var(--space-4);
  border-bottom: 1px solid var(--color-border);
  font-size: var(--text-sm);
}

tbody tr:hover {
  background: var(--color-paper-3);
}

tbody tr:last-child td {
  border-bottom: none;
}
```

### Navigation

**Sidebar Navigation**
```css
.sidebar {
  background: var(--color-paper);
  border-right: 1px solid var(--color-border);
  width: var(--sidebar-width);
  height: 100vh;
  position: sticky;
  top: 0;
  overflow-y: auto;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: var(--space-3);
  padding: var(--space-3) var(--space-4);
  border-radius: var(--radius-sm);
  color: var(--color-ink);
  text-decoration: none;
  font-size: var(--text-base);
  transition: var(--transition-colors);
}

.nav-item:hover {
  background: var(--color-paper-3);
}

.nav-item.active {
  background: var(--color-accent-subtle);
  color: var(--color-accent);
  font-weight: var(--font-weight-medium);
}
```

**Top Navigation**
```css
.top-nav {
  background: var(--color-paper);
  border-bottom: 1px solid var(--color-border);
  padding: var(--space-4) var(--space-6);
  display: flex;
  align-items: center;
  justify-content: space-between;
}
```

### Badges & Status

**Functional, not decorative**
```css
.badge {
  display: inline-flex;
  align-items: center;
  padding: var(--space-1) var(--space-3);
  font-size: var(--text-xs);
  font-weight: var(--font-weight-medium);
  border-radius: var(--radius-full);
  text-transform: uppercase;
  letter-spacing: var(--tracking-wider);
}

.badge-success {
  background: var(--color-success-subtle);
  color: var(--color-success);
}

.badge-warning {
  background: var(--color-warning-subtle);
  color: oklch(from var(--color-warning) calc(l * 0.7) c h);
}

.badge-danger {
  background: var(--color-danger-subtle);
  color: var(--color-danger);
}

.badge-neutral {
  background: var(--color-paper-3);
  color: var(--color-ink-2);
}
```

### Alerts

```css
.alert {
  display: flex;
  align-items: flex-start;
  gap: var(--space-3);
  padding: var(--space-4);
  border-left: 3px solid;
  border-radius: var(--radius-sm);
}

.alert-success {
  background: var(--color-success-subtle);
  border-color: var(--color-success);
}

.alert-danger {
  background: var(--color-danger-subtle);
  border-color: var(--color-danger);
}

.alert-warning {
  background: var(--color-warning-subtle);
  border-color: var(--color-warning);
}

.alert-info {
  background: var(--color-info-subtle);
  border-color: var(--color-info);
}
```

---

## Motion & Transitions

### Philosophy: Motion-Cut

This is a **motion-cut project**. No animation libraries (GSAP, Framer Motion, etc.) are installed or needed.

### Allowed Motion

**Hover Transitions** (150-200ms)
```css
button {
  transition: var(--transition-colors);
}
```

**Focus Rings** (Instant, no animation)
```css
*:focus-visible {
  outline: var(--focus-ring-width) solid var(--color-focus);
  outline-offset: var(--focus-ring-offset);
  transition: none; /* Focus rings appear instantly */
}
```

**Modal Enter/Exit** (200ms fade + scale)
```css
.modal {
  opacity: 0;
  transform: scale(0.95);
  transition: opacity var(--duration-base) var(--ease-out),
              transform var(--duration-base) var(--ease-out);
}

.modal.is-open {
  opacity: 1;
  transform: scale(1);
}
```

**Dropdown Slide** (150ms)
```css
.dropdown {
  opacity: 0;
  transform: translateY(-8px);
  transition: opacity var(--duration-fast) var(--ease-out),
              transform var(--duration-fast) var(--ease-out);
}

.dropdown.is-open {
  opacity: 1;
  transform: translateY(0);
}
```

**Toast/Alert Slide-in** (200ms)
```css
.toast {
  transform: translateX(100%);
  transition: transform var(--duration-base) var(--ease-out);
}

.toast.is-visible {
  transform: translateX(0);
}
```

### Banned Motion

❌ Parallax scrolling  
❌ Infinite rotating elements  
❌ Excessive hover lifts (>5px)  
❌ Attention-grabbing pulses  
❌ Auto-playing animations  
❌ Delayed hover states (>100ms)

### Reduced Motion

Always respect user preferences:
```css
@media (prefers-reduced-motion: reduce) {
  *,
  *::before,
  *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
}
```

---

## Accessibility

### Contrast Requirements

**WCAG AA Minimum**
- Normal text: 4.5:1
- Large text (18px+): 3:1
- UI components: 3:1
- Focus indicators: 3:1

**How to test**:
```css
/* All color combinations in this system meet WCAG AA */
/* Test new combinations at: https://www.siegemedia.com/contrast-ratio */
```

### Focus Management

**Always provide visible focus indicators**
```css
*:focus-visible {
  outline: var(--focus-ring-width) solid var(--color-focus);
  outline-offset: var(--focus-ring-offset);
}

/* Never do this */
*:focus {
  outline: none; /* ❌ Don't remove focus outlines */
}
```

### Keyboard Navigation

- Ensure logical tab order
- Provide skip links for main content
- Arrow keys for menus/tabs where appropriate
- Enter/Space activate buttons
- Escape closes modals/dropdowns

### Semantic HTML

Use proper HTML5 semantic elements:
```html
<nav>      - Navigation
<main>     - Main content
<aside>    - Sidebar
<article>  - Self-contained content
<section>  - Thematic grouping
<header>   - Introductory content
<footer>   - Footer content
```

### Screen Readers

**ARIA labels for icon-only buttons**
```html
<button aria-label="Close modal">
  <i class="icon-close"></i>
</button>
```

**Heading hierarchy** (no skips)
```html
<h1>Page Title</h1>
  <h2>Section</h2>
    <h3>Subsection</h3>
    <h3>Subsection</h3>
  <h2>Section</h2>
```

**Table headers**
```html
<th scope="col">Column Header</th>
<th scope="row">Row Header</th>
```

**Live regions**
```html
<div role="status" aria-live="polite">
  Book saved successfully
</div>
```

---

## Responsive Strategy

### Mobile-First Approach

Write CSS for mobile first, then enhance for larger screens:
```css
/* Mobile (default) */
.grid {
  grid-template-columns: 1fr;
}

/* Tablet */
@media (min-width: 768px) {
  .grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

/* Desktop */
@media (min-width: 1024px) {
  .grid {
    grid-template-columns: repeat(3, 1fr);
  }
}
```

### Component Adaptations

**Navigation**
- Mobile: Drawer sidebar + hamburger
- Desktop: Persistent sidebar

**Tables**
- Mobile: Stack to cards OR horizontal scroll
- Desktop: Full table

**Forms**
- Mobile: Full width, single column
- Desktop: Multi-column where appropriate

**Dashboard Cards**
- Mobile: Stack vertically
- Tablet: 2-column grid
- Desktop: 3-4 column grid

---

## Dark Mode

### Automatic Switching

Follow system preference by default:
```javascript
// Already implemented in layouts/app.blade.php
const theme = localStorage.getItem('theme') || 'light';
document.documentElement.setAttribute('data-theme', theme);
```

### Color Adjustments

All colors have dark mode variants defined in `tokens.css` under `[data-theme="dark"]`.

**Shadows become more subtle**:
```css
[data-theme="dark"] {
  --shadow-sm: 0 1px 2px oklch(0% 0 0 / 0.3);
  --shadow-md: 0 2px 4px oklch(0% 0 0 / 0.4);
  --shadow-lg: 0 4px 8px oklch(0% 0 0 / 0.5);
}
```

---

## Usage Guidelines

### Getting Started

1. **Import tokens in your main CSS**:
   ```css
   @import url('/css/tokens.css');
   ```

2. **Use semantic tokens, never raw values**:
   ```css
   /* ✅ Correct */
   color: var(--color-ink);
   padding: var(--space-4);
   
   /* ❌ Wrong */
   color: #1a1a1a;
   padding: 16px;
   ```

3. **Follow the component patterns**:
   - Copy component CSS from this document
   - Adjust spacing/colors using tokens only
   - Test in both light and dark modes

4. **Maintain consistency**:
   - Use the same button style project-wide
   - Use the same card treatment
   - Use the same form styling

### Testing Checklist

Before shipping any UI:

- [ ] Tested in both light and dark modes
- [ ] Tested at mobile (375px), tablet (768px), desktop (1280px)
- [ ] All interactive elements have visible focus states
- [ ] Color contrast meets WCAG AA (4.5:1 minimum)
- [ ] Works with keyboard navigation only
- [ ] Tested with screen reader (announce important states)
- [ ] Respects prefers-reduced-motion
- [ ] No console errors
- [ ] No horizontal scroll on mobile

---

## Version History

### 1.0.0 (2026-08-12)
- Initial design system establishment
- Newsprint theme selected
- Complete token system created
- Component patterns defined
- Motion-cut philosophy established
- Accessibility guidelines documented

---

## Questions?

This design system is a living document. If you find inconsistencies or need clarification, document them and update this file.

**Key Principle**: When in doubt, favor **simplicity and restraint** over decoration and complexity.
