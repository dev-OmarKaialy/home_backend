<!-- resources/views/pdf/house.blade.php -->
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
            /* أصغر قليلًا للخط */
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
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .images img {
            max-width: 120px;
            max-height: 80px;
            object-fit: cover;
            border: 1px solid #ccc;
        }

        .signature-box {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
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

    <h2>House Purchase / Rental Agreement</h2>

    <div class="contract-intro">
        <p>This agreement is made between the <span class="label">Owner</span> and the <span class="label">Buyer / Tenant</span> for the property described below. By signing this document, both parties agree to the terms of sale or rental.</p>
    </div>

    <h3 style="margin-bottom:5px;">Property Details</h3>
    <div class="section">
        <p><span class="label">Title:</span> {{ $house->title }}</p>
        <p><span class="label">Description:</span> {{ $house->description }}</p>
        <p><span class="label">Price:</span> {{ $house->price }} SYP</p>
        <p><span class="label">Status:</span> {{ ucfirst($house->status) }}</p>
        <p><span class="label">Rooms:</span> {{ $house->rooms }}</p>
        <p><span class="label">Space:</span> {{ $house->space }} m²</p>
        <p><span class="label">Directions:</span> {{ $house->directions }}</p>
        @if($house->status === 'rent')
        <p><span class="label">Rental Period:</span> {{ $house->period }}</p>
        @endif
        @if($house->images && count($house->images))
        <div class="images">
            @foreach($house->images as $img)
            <img src="{{ $img }}" alt="House Image">
            @endforeach
        </div>
        @endif
    </div>

    <h3 style="margin-bottom:5px;">Property Address</h3>
    <div class="section">
        <p><span class="label">City:</span> {{ $house->address->city ?? '' }}</p>
        <p><span class="label">Region:</span> {{ $house->address->region ?? '' }}</p>
        <p><span class="label">Street:</span> {{ $house->address->street ?? '' }}</p>
        <p><span class="label">Building:</span> {{ $house->address->building ?? '' }}</p>
    </div>

    <h3 style="margin-bottom:5px;">Owner Details</h3>
    <div class="section">
        <p><span class="label">Name:</span> {{ $house->owner_name }}</p>
        <p><span class="label">Phone:</span> {{ $house->owner_phone }}</p>
    </div>

    <h3 style="margin-bottom:5px;">Signatures</h3>
    <div class="signature-box">
        <div>Owner's Signature</div>
        <br>
        <br>
        <div>Buyer / Tenant's Signature</div>
        @if(!empty($buyerSignature))
        <img src="{{ $buyerSignature }}" alt="Buyer Signature" style="max-height:80px; margin-bottom:5px;">
        @endif
    </div>

</body>

</html>