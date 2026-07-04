<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $template->subject ?? "🎉 You're Registered! Welcome to the Prop Trading Mastery Webinar" }}</title>
</head>
<body style="font-family: Arial, sans-serif; color: #000000; line-height: 1.6; background-color: #ffffff; padding: 10px;">

    <div style="max-width: 100%; margin: 0 auto; background: #ffffff;">
        
        <p style="margin-bottom: 15px;">Dear <strong>{{ $data['name'] ?? 'Participant' }}</strong>,</p>
        
        <p style="margin-bottom: 15px;">Thank you for registering for the <strong>Prop Trading Mastery Webinar</strong>.</p>
        
        <p style="margin-bottom: 25px;">We're excited to have you join us for this exclusive live session where you'll discover professional prop trading concepts, proven risk management techniques, and the mindset required to trade with confidence.</p>

        <!-- Webinar Details Section -->
        <div style="margin-bottom: 25px;">
            <p style="margin: 0 0 10px 0; font-weight: bold; font-size: 16px;">📅 Webinar Details</p>
            @if($webinar)
                <p style="margin: 3px 0;"><strong>Program:</strong> {{ $webinar->title ?? 'wdasdfdsts' }}</p>
                <p style="margin: 3px 0;"><strong>Date:</strong> {{ \Carbon\Carbon::parse($webinar->webinar_date)->format('d M Y') }}</p>
                <p style="margin: 3px 0;"><strong>Time:</strong> {{ $webinar->webinar_time ?? '12:00 PM' }}</p>
                <p style="margin: 3px 0;"><strong>Duration:</strong> Approximately {{ $webinar->duration ?? '90' }} Minutes</p>
                <p style="margin: 3px 0;"><strong>Join Webinar:</strong> <a href="{{ $webinar->join_link ?? '#' }}" style="color: #0d6efd; text-decoration: underline;">{{ $webinar->join_link ?? 'https://meet.google.com/hcv-bkqn-odj' }}</a></p>
            @else
                <p style="margin: 3px 0;"><strong>Program:</strong> Prop Trading Mastery Webinar</p>
                <p style="margin: 3px 0;"><strong>Date:</strong> 03 Jul 2026</p>
                <p style="margin: 3px 0;"><strong>Time:</strong> 12:00 PM</p>
                <p style="margin: 3px 0;"><strong>Duration:</strong> Approximately 90 Minutes</p>
                <p style="margin: 3px 0;"><strong>Join Webinar:</strong> <a href="https://meet.google.com/hcv-bkqn-odj" style="color: #0d6efd; text-decoration: underline;">https://meet.google.com/hcv-bkqn-odj</a></p>
            @endif
        </div>

        <!-- Dynamic Parsed Body Content (Admin Highlight Note Place) -->
        @if(!empty($template->body_content))
        <div style="margin-bottom: 25px;">
            {!! $processedBody !!}
        </div>
        @endif

        <!-- Section 1: During This LIVE Session You'll Learn -->
        <div style="margin-bottom: 25px;">
            <p style="margin: 0 0 10px 0; font-weight: bold; font-size: 16px;">During This LIVE Session You'll Learn</p>
            <div style="margin: 0; padding: 0;">
                {{-- Admin ungalai ariyaamal unordered custom list update seithaalum athai automatic-ah <ol> aaga safe fallback seiyum code logic --}}
                {!! str_replace(['<ul>', '</ul>', '<ol>'], ['<ol style="margin: 0; padding-left: 20px;">', '</ol>', '<ol style="margin: 0; padding-left: 20px;">'], $template->what_you_will_learn) !!}
            </div>
        </div>

        <!-- Section 2: Before the Webinar -->
        <div style="margin-bottom: 25px;">
            <p style="margin: 0 0 10px 0; font-weight: bold; font-size: 16px;">Before the Webinar</p>
            <div style="margin: 0; padding: 0;">
                {!! str_replace(['<ul>', '</ul>', '<ol>'], ['<ol style="margin: 0; padding-left: 20px;">', '</ol>', '<ol style="margin: 0; padding-left: 20px;">'], $template->before_webinar) !!}
            </div>
        </div>

        <!-- Section 3: Need Assistance? (Keezhe brought pannapattuullathu) -->
        <div style="margin-top: 25px;">
            <p style="margin: 0 0 10px 0; font-weight: bold; font-size: 16px;">Need Assistance?</p>
            <p style="margin-bottom: 15px;">If you have any questions before the webinar, simply reply to this email and our support team will be happy to assist you.</p>
            <p style="margin-bottom: 15px;">We look forward to seeing you at the webinar and helping you take the next step in your trading journey.</p>
            
            <p style="margin-bottom: 0;">Best Regards,</p>
            <p style="margin: 5px 0 0 0; font-weight: bold; color: #000000;">Team {{ $template->company_name ?? 'Bliss Monk Tech Solutionsz' }}</p>
            
            <p style="margin: 3px 0 0 0;">Email: <a href="mailto:{{ $template->company_email ?? 'bharath@blissmonktech.com' }}" style="color: #0d6efd;">{{ $template->company_email ?? 'bharath@blissmonktech.com' }}</a></p>
            <p style="margin: 3px 0 0 0;">Phone: {{ $template->company_phone ?? '+91 9894180719' }}</p>
            <p style="margin: 3px 0 0 0;">Website: <a href="https://blissmonktech.com" style="color: #0d6efd;">https://blissmonktech.com</a></p>
        </div>
    </div>

</body>
</html>