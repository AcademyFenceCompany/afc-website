@extends('layouts.main')

@include('layouts.aboutHeader')

<main class="container py-5">
    <div class="card mb-4 shadow-sm">
        <p class="text-center text-muted mb-5">
            This privacy policy has been compiled to better serve those who are concerned with how their 'Personally Identifiable Information' (PII) is being used online.
        </p>

        <div class="card shadow-sm p-4">
            <h2 class="h5 mb-3">What personal information do we collect?</h2>
            <p>When ordering or registering on our site, as appropriate, you may be asked to enter your name, email address, mailing address, phone number, credit card information or other details to help you with your experience.</p>

            <h2 class="h5 mt-4 mb-3">When do we collect information?</h2>
            <p>We collect information from you when you register on our site, place an order, subscribe to a newsletter, fill out a form or enter information on our site.</p>

            <h2 class="h5 mt-4 mb-3">How do we use your information?</h2>
            <ul>
                <li>To allow us to better service you in responding to your customer service requests.</li>
                <li>To quickly process your transactions.</li>
                <li>To follow up with them after correspondence (live chat, email or phone inquiries).</li>
            </ul>

            <h2 class="h5 mt-4 mb-3">How do we protect your information?</h2>
            <p>Our website is scanned on a regular basis for security holes and known vulnerabilities in order to make your visit to our site as safe as possible. We use regular Malware Scanning.</p>
            <p>Your personal information is contained behind secured networks and is only accessible by a limited number of persons who have special access rights to such systems, and are required to keep the information confidential. In addition, all sensitive/credit information you supply is encrypted via Secure Socket Layer (SSL) technology.</p>
            <p>All transactions are processed through a gateway provider and are not stored or processed on our servers.</p>

            <h2 class="h5 mt-4 mb-3">Do we use cookies?</h2>
            <p>We do not use cookies for tracking purposes. However, disabling cookies might impact some site features.</p>

            <h2 class="h5 mt-4 mb-3">Third-party disclosure</h2>
            <p>We do not sell, trade, or otherwise transfer to outside parties your Personally Identifiable Information.</p>

            <h2 class="h5 mt-4 mb-3">Google</h2>
            <p>We use Google AdSense Advertising on our website. Google, as a third-party vendor, uses cookies to serve ads on our site. Users may opt out by visiting the <a href="https://policies.google.com/privacy" target="_blank">Google Ad and Content Network privacy policy</a>.</p>

            <h2 class="h5 mt-4 mb-3">California Online Privacy Protection Act (CalOPPA)</h2>
            <p>CalOPPA requires websites collecting data from California residents to post a privacy policy. Users can visit our site anonymously. Any changes to this policy will be reflected on this page.</p>

            <h2 class="h5 mt-4 mb-3">COPPA (Children's Online Privacy Protection Act)</h2>
            <p>We do not specifically market to children under the age of 13 years old.</p>

            <h2 class="h5 mt-4 mb-3">Fair Information Practices</h2>
            <p>In the event of a data breach, users will be notified via email within 7 business days. We adhere to the Individual Redress Principle, allowing users to take legal action if data processors fail to comply with laws.</p>

            <h2 class="h5 mt-4 mb-3">CAN-SPAM Act</h2>
            <p>We comply with the CAN-SPAM Act by not using false email subjects, honoring opt-out requests promptly, and including our physical address in emails.</p>

            <h2 class="h5 mt-4 mb-3">Contacting Us</h2>
            <p>If there are any questions regarding this privacy policy, you may contact us using the information below:</p>
            <address>
                Academy Fence Company<br>
                119 North Day Street<br>
                Orange, New Jersey 07050<br>
                Email: <a href="mailto:privacy@academyfence.com">privacy@academyfence.com</a>
            </address>
            <p class="text-muted">Last Edited on 2017-04-07</p>
        </div>
    </div>

    @include('layouts.footerproducts')
</main>
@endsection
