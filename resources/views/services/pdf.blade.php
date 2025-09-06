<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            direction: ltr;
            padding: 15px 25px;
            font-size: 12px;
            line-height: 1.4;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            font-size: 16px;
            text-decoration: underline;
        }

        .section {
            margin-bottom: 20px;
            padding: 10px 15px;
            border: 1px solid #aaa;
            border-radius: 5px;
        }

        .section p {
            margin: 4px 0;
        }

        .images {
            margin-top: 10px;
            text-align: center;
        }

        .images img {
            max-width: 150px;
            max-height: 100px;
            object-fit: cover;
            border: 1px solid #ccc;
        }

        .signature-box {
            margin-top: 50px;
            display: flex;
            justify-content: center;
        }

        .signature-box div {
            width: 45%;
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 5px;
            font-weight: bold;
        }

        .contract-intro {
            margin-bottom: 20px;
        }

        .contract-intro p {
            margin: 3px 0;
        }

        .label {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h2>Service Agreement Contract</h2>

    <div class="contract-intro">
        <p>
            This agreement is made between the <span class="label">Service Provider</span>
            and the <span class="label">Client</span> regarding the service described below.
            By signing this document, both parties agree to the terms of service delivery.
        </p>
    </div>

    <h3 style="margin-bottom:5px;">Service Details</h3>
    <div class="section">
        <p><span class="label">Service ID:</span> {{ $service->id }}</p>
        <p><span class="label">Name:</span> {{ $service->name }}</p>
        <p><span class="label">Category:</span> {{ $service->category->name ?? '' }}</p>
        <p><span class="label">Description:</span> {{ $service->description }}</p>

        @if(!empty($service->image_url))
        <div class="images">
            <img src="{{ $service->image_url }}" alt="Service Image">
        </div>
        @endif
    </div>

    <h3 style="margin-bottom:5px;">Provider Details</h3>
    <div class="section">
        <p><span class="label">Name:</span> {{ $service->provider->name ?? '' }}</p>
        <p><span class="label">Phone:</span> {{ $service->provider->phone ?? '' }}</p>
        <p><span class="label">Email:</span> {{ $service->provider->email ?? '' }}</p>
    </div>

    <h3 style="margin-bottom:5px;">Service Providers (Team)</h3>
    <div class="section">
        @if($service->serviceProviders && count($service->serviceProviders))
        <ul>
            @foreach($service->serviceProviders as $sp)
            <li>{{ $sp->name ?? '' }} - {{ $sp->role ?? '' }}</li>
            @endforeach
        </ul>
        @else
        <p>No additional providers assigned.</p>
        @endif
    </div>

    <h3 style="margin-bottom:5px;">Signatures</h3>
    <div class="signature-box">
        <div>Client's Signature</div>
        @if(!empty($buyerSignature))
        <img src="{{ $buyerSignature }}" alt="Client Signature" style="max-height:80px; margin-top:5px;">
        @endif
    </div>

</body>

</html>