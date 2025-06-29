<!-- resources/views/emails/contact-form.blade.php -->
<!-- Tutorial #64: Send Email | Laravel send mail with SMTP -->
<!-- Tutorial #67: Inline Blade template -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('New Contact Form Submission') }}</title>
    
    <!-- Tutorial #67: Inline Blade template styling -->
    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .email-header {
            background: linear-gradient(135deg, #007AFF 0%, #5856D6 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .email-header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .email-header p {
            opacity: 0.9;
            font-size: 0.9rem;
        }
        
        .email-body {
            padding: 2rem;
        }
        
        .contact-info {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid #007AFF;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 1rem;
            align-items: flex-start;
        }
        
        .info-row:last-child {
            margin-bottom: 0;
        }
        
        .info-label {
            font-weight: 600;
            color: #007AFF;
            min-width: 120px;
            font-size: 0.9rem;
        }
        
        .info-value {
            flex: 1;
            color: #333;
            word-break: break-word;
        }
        
        .message-section {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 1.5rem 0;
        }
        
        .message-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }
        
        .message-content {
            color: #555;
            line-height: 1.6;
            white-space: pre-wrap;
        }
        
        .action-buttons {
            text-align: center;
            margin: 2rem 0;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 0 0.5rem;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background-color: #007AFF;
            color: white;
        }
        
        .btn-success {
            background-color: #28a745;
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .email-footer {
            background: #f8f9fa;
            padding: 1.5rem;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        
        .footer-text {
            color: #6c757d;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
        
        .footer-links {
            margin-bottom: 1rem;
        }
        
        .footer-links a {
            color: #007AFF;
            text-decoration: none;
            margin: 0 1rem;
            font-size: 0.875rem;
        }
        
        .company-info {
            color: #6c757d;
            font-size: 0.8rem;
            line-height: 1.4;
        }
        
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .badge-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .priority-high {
            background: #ffebee;
            border-left-color: #f44336;
        }
        
        .priority-urgent {
            background: #fce4ec;
            border-left-color: #e91e63;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(233, 30, 99, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(233, 30, 99, 0); }
            100% { box-shadow: 0 0 0 0 rgba(233, 30, 99, 0); }
        }
        
        /* Mobile responsive */
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                box-shadow: none;
            }
            
            .email-header,
            .email-body,
            .email-footer {
                padding: 1rem;
            }
            
            .info-row {
                flex-direction: column;
            }
            
            .info-label {
                min-width: auto;
                margin-bottom: 0.25rem;
            }
            
            .btn {
                display: block;
                margin: 0.5rem 0;
            }
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .email-container {
                background-color: #1a1a1a;
                color: #ffffff;
            }
            
            .contact-info {
                background: #2a2a2a;
                color: #ffffff;
            }
            
            .message-section {
                background: #2a2a2a;
                border-color: #444;
                color: #ffffff;
            }
            
            .email-footer {
                background: #2a2a2a;
                border-color: #444;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Email Header -->
        <div class="email-header">
            <h1>{{ __('New Contact Form Submission') }}</h1>
            <p>{{ __('You have received a new message from your website') }}</p>
        </div>
        
        <!-- Email Body -->
        <div class="email-body">
            <!-- Contact Information -->
            <div class="contact-info {{ $contact->budget_range === 'over_50k' ? 'priority-high' : '' }}">
                <div class="info-row">
                    <span class="info-label">{{ __('Name:') }}</span>
                    <span class="info-value">{{ $contact->name }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">{{ __('Email:') }}</span>
                    <span class="info-value">
                        <a href="mailto:{{ $contact->email }}" style="color: #007AFF; text-decoration: none;">
                            {{ $contact->email }}
                        </a>
                    </span>
                </div>
                
                @if($contact->phone)
                <div class="info-row">
                    <span class="info-label">{{ __('Phone:') }}</span>
                    <span class="info-value">
                        <a href="tel:{{ $contact->phone }}" style="color: #007AFF; text-decoration: none;">
                            {{ $contact->phone }}
                        </a>
                    </span>
                </div>
                @endif
                
                @if($contact->company)
                <div class="info-row">
                    <span class="info-label">{{ __('Company:') }}</span>
                    <span class="info-value">{{ $contact->company }}</span>
                </div>
                @endif
                
                <div class="info-row">
                    <span class="info-label">{{ __('Subject:') }}</span>
                    <span class="info-value"><strong>{{ $contact->subject }}</strong></span>
                </div>
                
                @if($contact->service_interest)
                <div class="info-row">
                    <span class="info-label">{{ __('Services:') }}</span>
                    <span class="info-value">{{ $contact->service_interest }}</span>
                </div>
                @endif
                
                @if($contact->budget_range)
                <div class="info-row">
                    <span class="info-label">{{ __('Budget:') }}</span>
                    <span class="info-value">
                        <span class="badge {{ $contact->budget_range === 'over_50k' ? 'badge-success' : 'badge-info' }}">
                            @switch($contact->budget_range)
                                @case('under_5k')
                                    {{ __('Under $5,000') }}
                                    @break
                                @case('5k_10k')
                                    {{ __('$5,000 - $10,000') }}
                                    @break
                                @case('10k_25k')
                                    {{ __('$10,000 - $25,000') }}
                                    @break
                                @case('25k_50k')
                                    {{ __('$25,000 - $50,000') }}
                                    @break
                                @case('over_50k')
                                    {{ __('Over $50,000') }} 💰
                                    @break
                                @default
                                    {{ ucfirst(str_replace('_', ' ', $contact->budget_range)) }}
                            @endswitch
                        </span>
                    </span>
                </div>
                @endif
                
                <div class="info-row">
                    <span class="info-label">{{ __('Contact Preference:') }}</span>
                    <span class="info-value">{{ ucfirst($contact->preferred_contact) }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">{{ __('Submitted:') }}</span>
                    <span class="info-value">{{ $contact->created_at->format('M d, Y \a\t H:i') }}</span>
                </div>
            </div>
            
            <!-- Message Content -->
            <div class="message-section">
                <div class="message-title">{{ __('Message:') }}</div>
                <div class="message-content">{{ $contact->message }}</div>
            </div>
            
            <!-- Quick Response Section -->
            <div style="background: #e3f2fd; padding: 1rem; border-radius: 8px; margin: 1rem 0;">
                <h4 style="color: #1976d2; margin-bottom: 0.5rem;">{{ __('Quick Response Tips:') }}</h4>
                <ul style="color: #424242; margin: 0; padding-left: 1.5rem;">
                    <li>{{ __('Respond within 24 hours for best impression') }}</li>
                    <li>{{ __('Reference their specific interests and budget') }}</li>
                    @if($contact->budget_range === 'over_50k')
                        <li><strong>{{ __('High-value prospect - prioritize this inquiry!') }}</strong></li>
                    @endif
                    <li>{{ __('Include relevant portfolio examples') }}</li>
                </ul>
            </div>
            
            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}&body=Hi {{ $contact->name }},%0D%0A%0D%0AThank you for your interest in our services..." 
                   class="btn btn-primary">
                    📧 {{ __('Reply via Email') }}
                </a>
                
                @if($contact->phone)
                <a href="tel:{{ $contact->phone }}" class="btn btn-success">
                    📞 {{ __('Call Now') }}
                </a>
                @endif
            </div>
        </div>
        
        <!-- Email Footer -->
        <div class="email-footer">
            <div class="footer-text">
                {{ __('This email was automatically generated from your website contact form.') }}
            </div>
            
            <div class="footer-links">
                <a href="{{ route('admin.contacts.index') }}">{{ __('View in Dashboard') }}</a>
                <a href="{{ route('admin.dashboard') }}">{{ __('Admin Panel') }}</a>
                <a href="{{ route('home') }}">{{ __('Visit Website') }}</a>
            </div>
            
            <div class="company-info">
                <strong>{{ config('app.name') }}</strong><br>
                123 Innovation Street, Tech District<br>
                Batangas 4200, Philippines<br>
                📧 hello@innovations-marketing.com | 📞 +63 912 345 6789
            </div>
        </div>
    </div>
</body>
</html>