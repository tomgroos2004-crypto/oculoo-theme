# CLAUDE.md
Project guidelines for AI assistants working in this repository.

This project is a **custom WordPress child theme** that uses **ACF-driven components** and a modular section system.

The architecture separates:
- **Design system (CSS tokens)**
- **Reusable ACF components**
- **Template sections**
- **Assets**

AI assistants should follow this structure strictly.


# PROJECT STRUCTURE

Theme structure overview:

/assets
  /css
    colors.css
    layout.css
    spacing.css
    typography.css
    buttons.css

  /widgets
    (CSS specific to ACF components)

/template-parts
  /sections
    (HTML / PHP markup for ACF sections)

functions.php
style.css


# CSS ARCHITECTURE

Global CSS lives in:

/assets/css/

These files contain the **design system and layout primitives**.

Example files:

- colors.css → color tokens and surfaces  
- layout.css → containers, grids, layout utilities  
- spacing.css → section spacing tokens  
- typography.css → fonts and text scale  
- buttons.css → button components  

Example token definition:

```css
:root {
  --color-primary: #0F2438;
  --color-accent: #EC6907;
}
```

# CSS CONSISTENCY RULE (MANDATORY)

Use the design-system files as the single source of truth. When editing or creating frontend code, always keep these aligned:

- `/assets/css/colors.css`
- `/assets/css/layout.css`
- `/assets/css/spacing.css`
- `/assets/css/typography.css`
- `/assets/css/buttons.css`
- component CSS in `/assets/css/widgets/`

Required behavior for AI assistants:

1. Reuse existing utility classes and tokens first (`.ls-container`, `.section-sm/.section-md/.section-lg`, `.btn-*`, `--color-*`, etc.).
2. Do not hardcode one-off values in components when a global token/utility exists.
3. If markup classes are changed in templates, update the corresponding CSS files in the same task.
4. If global tokens are changed (for branding), verify affected components still match and remain readable.
5. Keep components compatible with the global system so the whole website remains visually consistent and working.
6. For new sections, follow the same class architecture (global primitives + widget-specific classes), not isolated inline styling.
