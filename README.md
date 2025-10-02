# MED CLINICAL RESEARCH - Landing Page

A bilingual landing page for MED CLINICAL RESEARCH, LLC's health screening study recruitment.

## Features

- **Language Selection**: Users can choose between English and Spanish versions
- **Interest Form**: Comprehensive form for potential study participants
- **Eligibility Screening**: Questions based on the clinical trial requirements
- **Contact Time Preferences**: 4 time slots for preferred contact times
- **Referral System**: Users can refer others to the study
- **Email Notifications**: Automatic emails to both you and the participant
- **Responsive Design**: Works on desktop and mobile devices
- **Professional Styling**: Matches the flyer design with dark blue theme

## Files Structure

- `index.html` - Language selection page
- `english.html` - English version of the landing page
- `spanish.html` - Spanish version of the landing page
- `process_form.php` - Backend script to handle form submissions
- `README.md` - This documentation file

## Setup Instructions

### 1. Web Server Requirements
- PHP 7.0 or higher
- Web server (Apache, Nginx, or similar)
- Email functionality enabled

### 2. Installation
1. Upload all files to your web server
2. Ensure the web server has PHP enabled
3. Make sure the `process_form.php` file is executable
4. Test the email functionality

### 3. Email Configuration
The form sends emails to `info@medclinicalresearch.com`. To change this:
1. Open `process_form.php`
2. Find the line: `$to = "info@medclinicalresearch.com";`
3. Change to your desired email address

### 4. Customization
- **Company Information**: Update contact details in both HTML files
- **Email Address**: Modify the recipient email in `process_form.php`
- **Styling**: Edit the CSS in the `<style>` sections of each HTML file
- **Form Fields**: Add or remove form fields as needed

## Form Features

### Eligibility Questions
- Are you at least 50 years old?
- Do you take cholesterol medication?
- Do you have a family history of high cholesterol, diabetes, or hypertension?

### Contact Time Options
- 9:00 AM - 12:00 PM
- 12:00 PM - 3:00 PM
- 3:00 PM - 6:00 PM
- 6:00 PM - 9:00 PM

### Referral System
- Users can choose to participate themselves or refer someone else
- Referral form includes name and phone number fields
- Referral fields only appear when "Referring someone" is selected

## Email Notifications

When someone submits the form:
1. **Admin Email**: Sent to `info@medclinicalresearch.com` with all form details
2. **Confirmation Email**: Sent to the participant confirming their submission

## Browser Compatibility

- Chrome (recommended)
- Firefox
- Safari
- Edge
- Mobile browsers

## Security Notes

- Form validation is performed on both client and server side
- Email addresses are validated
- Required fields are enforced
- XSS protection through proper data handling

## Support

For technical support or modifications, contact your web developer or hosting provider.

## License

This project is created for MED CLINICAL RESEARCH, LLC.
