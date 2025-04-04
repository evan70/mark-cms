<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ContactController extends Controller
{
    /**
     * Display contact page
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        return $this->render($response, $request, 'contact', [
            'title' => 'Contact Us',
            'metaDescription' => 'Get in touch with our team. We\'re here to help with any questions or inquiries you may have.',
        ]);
    }
    
    /**
     * Process contact form submission
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function submit(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        
        // Validate form data
        $errors = $this->validateContactForm($data);
        
        if (!empty($errors)) {
            // Return to form with errors
            return $this->render($response, $request, 'contact', [
                'title' => 'Contact Us',
                'metaDescription' => 'Get in touch with our team. We\'re here to help with any questions or inquiries you may have.',
                'errors' => $errors,
                'formData' => $data,
            ]);
        }
        
        // Process form (e.g., send email)
        // This is a placeholder - you would implement actual email sending here
        
        // Store success message in session
        $_SESSION['success_message'] = 'Thank you for your message. We\'ll get back to you soon.';
        
        // Redirect to prevent form resubmission
        return $response->withHeader('Location', '/' . ($request->getAttribute('language') ?? 'sk') . '/contact')
                        ->withStatus(302);
    }
    
    /**
     * Validate contact form data
     *
     * @param array $data Form data
     * @return array Validation errors
     */
    private function validateContactForm(array $data): array
    {
        $errors = [];
        
        // Validate name
        if (empty($data['name'])) {
            $errors['name'] = 'Name is required';
        }
        
        // Validate email
        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address';
        }
        
        // Validate message
        if (empty($data['message'])) {
            $errors['message'] = 'Message is required';
        } elseif (strlen($data['message']) < 10) {
            $errors['message'] = 'Message must be at least 10 characters long';
        }
        
        return $errors;
    }
}
