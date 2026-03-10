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