<!-- Use this file to provide workspace-specific custom instructions to Copilot. For more details, visit https://code.visualstudio.com/docs/copilot/copilot-customization#_use-a-githubcopilotinstructionsmd-file -->

# Chilean Raffle Management System - Copilot Instructions

This is a PHP MVC application for managing raffles in Chile with the following characteristics:

## Architecture
- **Backend**: PHP with custom MVC pattern
- **Database**: MySQL with Chilean localization
- **Frontend**: JavaScript (modular) + Tailwind CSS (Glassmorphism style)
- **Email**: PHPMailer integration
- **Routing**: Slug-based URLs (no IDs in URLs)

## Key Features
- Multi-level user system (Super Admin, Admin, Vendor, Buyer)
- Three types of raffle inventory management
- Real-time notification system with logging
- Installation wizard for setup
- Environment-based configuration
- Chilean date/currency formatting
- SEO and analytics integration
- WYSIWYG content management

## Code Standards
- Follow PSR standards for PHP
- Modular JavaScript (ui.js for visual, logic.js for calculations)
- Glassmorphism design with Tailwind CSS
- Chilean localization (CLP currency, Spanish language, Chilean date formats)
- Slug-based routing for all public URLs
- Comprehensive error handling and validation
- Security-first approach with environment variables

## Database Design
- Modular table structure by entity
- Soft deletes with archive tables
- Chilean-specific fields (RUT validation)
- Action logging for notifications and auditing
