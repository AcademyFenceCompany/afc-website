@extends('layouts.main')

@include('layouts.aboutHeader')

<!-- Policies Content Section -->
<div class="card mb-4 shadow-sm">
    <div class="p-4">
        <div class="row">
            <h2 class="text-center fw-bold">General Policies</h2>
            <!-- Column 1 -->
            <div class="col-md-6 policy-box">
                <h5 class="fw-bold">Return Policy</h5>
                <p>We take great pride in the quality of our products. If you are not satisfied with your purchase, you
                    may return the item in its original, unused condition with tags attached within <strong>5
                        days</strong> of receipt. Prior to returning, please contact us via email or phone to obtain a
                    return authorization number—returns without authorization will not be accepted.</p>

                <p>All returned items will be inspected, and if deemed unused and in new condition, a refund will be
                    issued for the purchase price <strong>minus shipping costs, handling fees, and a 25% restocking
                        fee</strong>. Returns must be shipped at your expense using a carrier of your choice. We
                    strongly recommend selecting a <strong>traceable shipping method</strong> such as UPS or FedEx,
                    which provide tracking details. The U.S. Postal Service also offers delivery confirmation for an
                    additional fee.</p>

                <ul>
                    <li>
                        <strong>Orders canceled on the same day before <span class="text-dark">4:00 PM
                                EST</span></strong>
                        will not incur any additional charges.
                    </li>
                    <li>
                        <strong>Cancellations made after <span class="text-dark">4:00 PM EST</span></strong>
                        will be subject to a <strong class="text-danger">5% administrative fee</strong>, along with any
                        costs related to the order’s preparation
                        (e.g., quality checks, packaging, shipping readiness).
                    </li>
                    <li>
                        If the order has already been shipped, a refund will be issued for the purchase price
                        <strong class="text-danger">minus shipping costs, handling fees, and a 25% restocking
                            fee</strong>.
                    </li>
                </ul>

                <p><strong>Please note:</strong> <span class="text-danger">Special, promotional, and clearance items are
                        <strong>final sale</strong> and non-refundable.</span></p>

                <p>Once your return is received at our warehouse, please allow <strong>up to 14 business days</strong>
                    for processing and credit issuance.</p>

                <h5 class="fw-bold">Defective Return</h5>
                <p>Items claimed as defective must be returned in their <strong>original packaging</strong>; otherwise,
                    they may be classified as <strong class="text-danger">misuse-related damage</strong>, and no credit
                    will be issued. Approved defective returns will receive <strong class="fw-bold">in-house credit
                        only</strong>.</p>

                <h5 class="fw-bold">Lost - Shipments and Claims</h5>

                <p>In the rare event that a package is lost during transit after being picked up from our shipping
                    facility, the responsibility falls on the shipping carrier. While Academy Fence Company is not
                    liable for lost shipments, we recommend reaching out directly to the shipping company to file a
                    claim. If you need assistance, we are happy to help guide you through the process.</p>

                <h6 class="fw-bold">You will have two options for proceeding:</h6>
                <ol>
                    <li>
                        <strong>File a Claim & Wait for Resolution:</strong> We will provide you with the necessary
                        claim details and instructions. Once the claim is settled with the shipping carrier, we will
                        reship your purchased items at no additional cost. Please note that this process may take
                        several weeks.
                    </li>
                    <li>
                        <strong>Repurchase & Reimbursement:</strong> You may choose to repurchase the order, and we will
                        promptly reship the items. Once the shipping company resolves the original claim, we will
                        reimburse you for the lost shipment.
                    </li>
                </ol>
            </div>

            <!-- Column 2 -->
            <div class="col-md-6 policy-box">
                <h5 class="fw-bold">Damaged or Opened Box Upon Arrival:</h5>
                <p>We thoroughly inspect all items before shipping to ensure they are in good condition. If you receive
                    a damaged package or item, you must report it to the shipping carrier&rsquo;s driver immediately so
                    they
                    can document your claim. Customers are responsible for filing a claim with the carrier&rsquo;s
                    claims
                    department for any lost or damaged items. We are not responsible for delays, loss, or damage that
                    occurs during transportation.</p>

                <p>Once you have reported the damage to the shipping driver and obtained written confirmation, please
                    contact our customer service. We follow one of two procedures:</p>

                <ol>
                    <li>
                        We submit a claim for the damaged item, allowing you to reorder it immediately. Once the claim
                        is processed, we will issue a refund for the approved amount.
                    </li>
                    <li>
                        We submit the claim, and you wait for the shipping carrier to finalize it before we resend the
                        item to you.
                    </li>
                </ol>

                <p>For assistance, please reach out to our customer service team.</p>

                <h5 class="fw-bold">Refusals or Undeliverable Orders</h5>
                <p>If an order is refused or deemed undeliverable, the customer will be responsible for a <strong>30%
                        processing and restocking fee</strong>. Additionally, shipping costs for both the initial
                    delivery and the return to our facility will be charged. We encourage customers to double-check
                    their shipping details to avoid any unnecessary fees.</p>

                <h5 class="fw-bold">Cancelled or Changed Orders</h5>
                <p>If the cancellation or changes are made on the same day the order is placed, no additional fee will
                    apply. Otherwise, orders canceled or modified before the materials have been shipped will incur a
                    <strong>5% administrative fee</strong>.
                </p>

                <h5 class="fw-bold">Freight</h5>
                <p>While we strive to provide accurate shipping costs, freight prices may occasionally be subject to
                    change due to unforeseen factors. In such rare cases, we will reach out to you promptly to discuss
                    any necessary price adjustments before proceeding with your order.</p>

                <h5 class="fw-bold">Important Notice:</h5>
                <p>By placing an order with us, you acknowledge and agree to our policies, terms, and conditions.</p>

            </div>
            <!-- <div class="col">
                <h2 class="text-center fw-bold">Product Specific Information</h2> -->

                <!-- Column 1 -->
                <!-- <div class="col-md-6 policy-box">
                    <h5 class="fw-bold">Welded Wire</h5>
                    <ul>
                        <li>If you cancel your order on the same day before 4:00 PM EST, no additional charges will
                            apply.
                        </li>
                        <li>If you cancel after 4:00 PM EST, a 5% fee will be charged, along with any additional costs
                            depending on the order&rsquo;s preparation status, such as quality checks, packaging, and
                            readiness
                            for shipping.</li>
                        <li>If the product has already been shipped, a refund will be issued for the purchase price
                            minus
                            shipping costs, handling fees, and a 25% restocking fee. Returns must be shipped at your
                            expense
                            using a carrier of your choice.</li>
                        <li>If the product is damaged &ndash; If the product arrives damaged, report it
                            to
                            the
                            shipping carrier immediately and obtain written confirmation. Then, contact our customer
                            service
                            for assistance.</li>
                    </ul>
                </div> -->
            <!-- </div> -->

        </div>
    </div>
</div>
{{-- @include('layouts.footerproducts') --}}
</main>
@endsection