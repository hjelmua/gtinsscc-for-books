<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Label PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 600px; margin-top: 50px; }
        .card { padding: 20px; border-radius: 10px; }
        .btn-primary { background-color: #007bff; border-color: #007bff; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card shadow-sm">
            <h2 class="text-center text-primary">Label PDF Generator</h2>
            <form action="generate_pdf.php" method="post" class="mt-3">
                <div class="mb-3">
                    <label class="form-label">Artikelnummer (ISBN)</label>
                    <input type="text" name="article_number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Shipment Date Part</label>
                    <input type="text" name="shipment_date" class="form-control" required>
                    <small class="text-muted">Enter the date part (e.g., 250114).</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Parcel Sequence Number</label>
                    <input type="number" name="parcel_number" class="form-control" required>
                    <small class="text-muted">Enter the sequence number (e.g., 7 for the 7th package. 1-9).</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Beskrivning</label>
                    <input type="text" name="description" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Datum</label>
                    <input type="text" name="date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kundorder nr</label>
                    <input type="text" name="customer_order" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Batch</label>
                    <input type="text" name="batch" class="form-control" required>
                    <small class="text-muted">Often the same as Shipment Date</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Antal</label>
                    <input type="number" name="quantity" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Övrigt</label>
                    <input type="text" name="notes" class="form-control">
                     <small class="text-muted">Example: 200 of 600. Or none</small>
                </div>
                <button type="submit" class="btn btn-primary w-100">Generate PDF</button>
            </form>
        </div>
        <div class="fixed-bottom d-flex justify-content-right"><a href="https://github.com/hjelmua/gtinsscc-for-books" class="btn btn-light btn-sm"><i class="bi bi-github"></i> open source code by hjelmua</a></div>
    </div>
</body>
</html>
