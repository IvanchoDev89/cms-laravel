# UI Components Documentation

## Overview

This document describes the professional UI component library built for the Laravel CMS. All components use Tailwind CSS and Alpine.js for styling and interactivity.

## Components

### Button (`x-ui.button`)

Versatile button component with multiple variants and sizes.

**Props:**
- `variant`: `primary` | `secondary` | `danger` | `warning` | `success` | `ghost`
- `size`: `sm` | `md` | `lg`
- `type`: `button` | `submit` | `reset` (default: button)
- `href`: URL (renders as link if provided)
- `disabled`: boolean
- `loading`: boolean
- `icon`: SVG string (optional)

**Examples:**
```blade
<x-ui.button variant="primary">Save</x-ui.button>
<x-ui.button variant="secondary" size="sm" icon='<svg>...</svg>'>Cancel</x-ui.button>
<x-ui.button href="/posts" variant="ghost">Back</x-ui.button>
```

### Card (`x-ui.card`)

Flexible container component with various styling options.

**Props:**
- `padding`: `none` | `sm` | `md` | `lg`
- `shadow`: `none` | `sm` | `md` | `lg`
- `hover`: boolean (adds hover effects)
- `gradient`: boolean (adds gradient border)
- `href`: URL (renders as link)

**Examples:**
```blade
<x-ui.card padding="lg" hover>
    <h3>Card Title</h3>
    <p>Card content here</p>
</x-ui.card>
```

### Alert (`x-ui.alert`)

Alert messages with different severity levels.

**Props:**
- `type`: `info` | `success` | `warning` | `error`
- `title`: string (optional header)
- `dismissible`: boolean (show close button)
- `icon`: boolean (show type icon)

**Examples:**
```blade
<x-ui.alert type="success" title="Success!" dismissible>
    Your changes have been saved.
</x-ui.alert>
```

### Input (`x-ui.input`)

Professional form input with label, error handling, and icons.

**Props:**
- `name`: string
- `type`: text types (default: text)
- `label`: string (optional)
- `placeholder`: string
- `helper`: string (helper text)
- `error`: string (error message)
- `icon`: SVG string (left icon)
- `iconPosition`: `left` | `right`
- `required`: boolean
- `disabled`: boolean

**Examples:**
```blade
<x-ui.input 
    name="email" 
    type="email" 
    label="Email Address" 
    placeholder="Enter your email"
    required
/>
```

### Textarea (`x-ui.textarea`)

Multi-line text input with auto-resize option.

**Props:**
- `name`: string
- `label`: string
- `rows`: int (default: 4)
- `autoResize`: boolean
- `maxLength`: int
- `helper`: string
- `error`: string

**Examples:**
```blade
<x-ui.textarea 
    name="content" 
    label="Content" 
    rows="6"
    autoResize
    maxLength="1000"
/>
```

### Select (`x-ui.select`)

Styled dropdown select component.

**Props:**
- `name`: string
- `label`: string
- `options`: array [value => label]
- `placeholder`: string
- `helper`: string
- `error`: string
- `icon`: SVG string

**Examples:**
```blade
<x-ui.select 
    name="status" 
    label="Status"
    :options="['draft' => 'Draft', 'published' => 'Published']"
    placeholder="Select status"
/>
```

### Badge (`x-ui.badge`)

Status and category indicator badges.

**Props:**
- `variant`: `primary` | `secondary` | `success` | `warning` | `danger` | `info` | `gray` | `purple`
- `size`: `sm` | `md` | `lg`
- `pill`: boolean (rounded full)
- `dot`: boolean (show colored dot)

**Examples:**
```blade
<x-ui.badge variant="success" dot>Published</x-ui.badge>
<x-ui.badge variant="primary" size="sm">New</x-ui.badge>
```

### Modal (`x-ui.modal`)

Dialog modal with backdrop and transitions.

**Props:**
- `open`: Alpine.js variable name
- `size`: `sm` | `md` | `lg` | `xl` | `full`
- `title`: string
- `hideClose`: boolean

**Examples:**
```blade
<div x-data="{ open: false }">
    <button @click="open = true">Open Modal</button>
    
    <x-ui.modal open="open" title="Confirm Action">
        <p>Are you sure?</p>
        <x-slot:footer>
            <x-ui.button @click="open = false" variant="secondary">Cancel</x-ui.button>
            <x-ui.button variant="danger">Delete</x-ui.button>
        </x-slot:footer>
    </x-ui.modal>
</div>
```

### Toast (`x-ui.toast`)

Notification system with auto-dismiss.

Include in layout:
```blade
@include('components.ui.toast')
```

Trigger in JavaScript:
```javascript
showToast('Message saved!', 'success');
toastError('Something went wrong');
toastWarning('Please check your input');
toastInfo('New update available');
```

**Parameters:**
- `message`: string
- `type`: `info` | `success` | `warning` | `error`
- `title`: string (optional)
- `duration`: milliseconds (default: 5000)

## Design System

### Colors

- Primary: Blue (`blue-600`)
- Success: Emerald (`emerald-500`)
- Warning: Amber (`amber-500`)
- Error: Red (`red-500`)
- Info: Cyan (`cyan-500`)

### Typography

- Headings: `text-2xl`, `text-xl`, `text-lg`, `text-base`
- Body: `text-sm`, `text-base`
- Small: `text-xs`

### Spacing

- Card padding: `p-4`, `p-6`, `p-8`
- Component gaps: `gap-2`, `gap-4`, `gap-6`
- Section spacing: `py-12`, `py-20`

### Dark Mode

All components support dark mode using Tailwind's `dark:` prefix. The `dark` class is applied to the root element based on system preferences or user selection.

## Best Practices

1. **Accessibility**: All components include ARIA labels and keyboard navigation
2. **Responsive**: Components adapt to mobile, tablet, and desktop screens
3. **Performance**: Minimal JavaScript, CSS-only where possible
4. **Consistency**: Use the same patterns across all admin views
5. **Validation**: Use `error` prop for form validation feedback

## Usage in Views

All components are located in `resources/views/components/ui/` and can be used with the `x-ui.` prefix:

```blade
<x-ui.button variant="primary">Click me</x-ui.button>
<x-ui.card padding="lg">Content here</x-ui.card>
```
