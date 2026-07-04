<?php

namespace App\Mail;

use App\Models\Webinar;
use App\Models\EmailTemplate; // Dynamic template table model
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WebinarUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $webinar;
    public $template;
    public $processedBody;

    public function __construct($data)
    {
        $this->data = $data;

        // Upcoming webinar details fetching
        $this->webinar = Webinar::where('status', 'upcoming')
            ->orderBy('webinar_date')
            ->first();

        // Admin template configurations fetching
        $this->template = EmailTemplate::first() ?? new EmailTemplate();

        // CKEditor content-il ulla placeholders (`{{name}}`, etc.) parse seiyum logic
        $this->processedBody = $this->parsePlaceholders($this->template->body_content);
    }

    /**
     * Replaces shortcodes inside the dynamic description area
     */
    protected function parsePlaceholders($content)
    {
        if (empty($content)) {
            // Default fallback note text if admin left it empty
            return 'Please contact this participant if any additional webinar information or reminders need to be shared.';
        }
        
        $placeholders = [
            '{{name}}'  => $this->data['name'] ?? '',
            '{{phone}}' => $this->data['phone'] ?? '',
            '{{email}}' => $this->data['email'] ?? '',
            '{{city}}'  => $this->data['city'] ?? '',
            '{{date}}'  => now()->format('d M Y h:i A'),
        ];

        return str_replace(array_keys($placeholders), array_values($placeholders), $content);
    }

    public function build()
    {
        // Admin panel-il irundhu subject lines set seigிறோம் (Fallback text-um ullathu)
        $subjectText = $this->template->subject ?? "🎉 You're Registered! Welcome to the Prop Trading Mastery Webinar";

        return $this->subject($subjectText)
                    ->view('emails.webinar-user');
    }
}