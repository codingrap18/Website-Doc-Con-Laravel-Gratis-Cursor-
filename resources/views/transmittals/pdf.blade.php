<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transmittal Letter {{ $transmittal->transmittal_number }}</title>
    <style>
        @page {
            margin: 2cm;
            margin-top: 3cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            position: fixed;
            top: -2.5cm;
            left: 0;
            right: 0;
            height: 2.5cm;
            background-color: #1e40af;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-left {
            flex: 1;
        }

        .header-right {
            text-align: right;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .company-tagline {
            font-size: 10px;
            color: #93c5fd;
        }

        .transmittal-number {
            font-size: 14px;
            font-weight: bold;
        }

        .transmittal-date {
            font-size: 10px;
            color: #93c5fd;
        }

        .content {
            margin-top: 30px;
        }

        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-section {
            margin-bottom: 25px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
        }

        .info-header {
            background-color: #f3f4f6;
            padding: 8px 12px;
            font-weight: bold;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-content {
            padding: 12px;
        }

        .info-row {
            display: flex;
            margin-bottom: 8px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-weight: bold;
            width: 120px;
            color: #374151;
        }

        .info-value {
            flex: 1;
            color: #111827;
        }

        .documents-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }

        .documents-table th {
            background-color: #f9fafb;
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            color: #374151;
        }

        .documents-table td {
            border: 1px solid #d1d5db;
            padding: 8px;
            vertical-align: top;
        }

        .documents-table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 12px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-ns { background-color: #f3f4f6; color: #374151; }
        .status-ifr { background-color: #dbeafe; color: #1e40af; }
        .status-rifr { background-color: #dbeafe; color: #1e40af; }
        .status-ifa { background-color: #fef3c7; color: #92400e; }
        .status-rifa { background-color: #fef3c7; color: #92400e; }
        .status-ifc { background-color: #d1fae5; color: #065f46; }
        .status-rifc { background-color: #d1fae5; color: #065f46; }
        .status-ifi { background-color: #ede9fe; color: #5b21b6; }

        .footer {
            position: fixed;
            bottom: -2cm;
            left: 0;
            right: 0;
            height: 1.5cm;
            font-size: 9px;
            color: #6b7280;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }

        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 15px;
            height: 80px;
        }

        .signature-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #374151;
        }

        .signature-line {
            border-top: 1px solid #9ca3af;
            margin-top: 40px;
            padding-top: 5px;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
        }

        .notes-section {
            margin-top: 25px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 15px;
            background-color: #f9fafb;
        }

        .notes-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #374151;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <div class="company-name">PT Pertamina</div>
            <div class="company-tagline">Engineering Document Control System</div>
        </div>
        <div class="header-right">
            <div class="transmittal-number">{{ $transmittal->transmittal_number }}</div>
            <div class="transmittal-date">{{ $transmittal->date->format('F d, Y') }}</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div>PT Pertamina - Engineering Document Control System</div>
        <div>This transmittal letter was generated on {{ now()->format('F d, Y \a\t g:i A') }}</div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="title">Document Transmittal Letter</div>

        <!-- Basic Information -->
        <div class="info-section">
            <div class="info-header">Transmittal Information</div>
            <div class="info-content">
                <div class="info-row">
                    <div class="info-label">Transmittal No:</div>
                    <div class="info-value">{{ $transmittal->transmittal_number }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Date:</div>
                    <div class="info-value">{{ $transmittal->date->format('F d, Y') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">To:</div>
                    <div class="info-value">{{ $transmittal->vendor_name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">From:</div>
                    <div class="info-value">{{ $transmittal->creator->name }} ({{ ucfirst($transmittal->creator->role) }})</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Subject:</div>
                    <div class="info-value">{{ $transmittal->description }}</div>
                </div>
            </div>
        </div>

        <!-- Document List -->
        <div class="info-section">
            <div class="info-header">Transmitted Documents ({{ count($documents) }} items)</div>
            <div class="info-content">
                <table class="documents-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No.</th>
                            <th style="width: 20%;">Document Number</th>
                            <th style="width: 35%;">Document Title</th>
                            <th style="width: 8%;">Rev.</th>
                            <th style="width: 12%;">Status</th>
                            <th style="width: 20%;">Position</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $index => $document)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td style="font-weight: bold;">{{ $document->document_number }}</td>
                            <td>{{ $document->document_title }}</td>
                            <td style="text-align: center;">{{ $document->revision }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($document->status) }}">
                                    {{ $document->status }}
                                </span>
                            </td>
                            <td>{{ $document->document_position ?: 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Status Legend -->
        <div class="info-section">
            <div class="info-header">Document Status Legend</div>
            <div class="info-content">
                <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                    <div><strong>NS:</strong> Not Submitted</div>
                    <div><strong>IFR:</strong> Issued for Review</div>
                    <div><strong>RIFR:</strong> Re-Issued for Review</div>
                    <div><strong>IFA:</strong> Issued for Approval</div>
                    <div><strong>RIFA:</strong> Re-Issued for Approval</div>
                    <div><strong>IFC:</strong> Issued for Construction</div>
                    <div><strong>RIFC:</strong> Re-Issued for Construction</div>
                    <div><strong>IFI:</strong> Issued for Information</div>
                </div>
            </div>
        </div>

        <!-- Notes Section -->
        <div class="notes-section">
            <div class="notes-title">Notes:</div>
            <div style="color: #6b7280; font-style: italic;">
                • Please acknowledge receipt of this transmittal<br>
                • Review all documents and provide feedback as required<br>
                • Contact the engineering team for any clarifications<br>
                • Return reviewed documents as per project schedule
            </div>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-title">Prepared By:</div>
                <div class="signature-line">
                    {{ $transmittal->creator->name }}<br>
                    {{ ucfirst(str_replace('_', ' ', $transmittal->creator->role)) }}
                </div>
            </div>

            <div class="signature-box">
                <div class="signature-title">Received By:</div>
                <div class="signature-line">
                    Name & Signature<br>
                    Date: _______________
                </div>
            </div>
        </div>
    </div>
</body>
</html>

