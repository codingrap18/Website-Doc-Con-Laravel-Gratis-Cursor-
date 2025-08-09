<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .subtitle {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .status {
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
        }
        .status-ns { background-color: #f3f4f6; color: #374151; }
        .status-ifr { background-color: #dbeafe; color: #1e40af; }
        .status-ifa { background-color: #fef3c7; color: #92400e; }
        .status-ifc { background-color: #d1fae5; color: #065f46; }
        .overdue { color: #dc2626; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Documents Export Report</div>
        <div class="subtitle">Generated on {{ now()->format('F d, Y \a\t g:i A') }}</div>
        <div class="subtitle">Total Documents: {{ count($documents) }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Document Number</th>
                <th>Document Title</th>
                <th>Rev.</th>
                <th>Status</th>
                <th>Submission Date</th>
                <th>Target Date</th>
                <th>Latest Reviewer</th>
                <th>Position</th>
                <th>Overdue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documents as $index => $document)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $document->document_number }}</td>
                <td>{{ $document->document_title }}</td>
                <td>{{ $document->revision }}</td>
                <td>
                    <span class="status status-{{ strtolower($document->status) }}">
                        {{ $document->status }}
                    </span>
                </td>
                <td>{{ $document->submission_date?->format('M d, Y') ?: 'N/A' }}</td>
                <td>{{ $document->target_date?->format('M d, Y') ?: 'N/A' }}</td>
                <td>{{ $document->latestReviewer?->name ?: 'Unassigned' }}</td>
                <td>{{ $document->document_position ?: 'N/A' }}</td>
                <td class="{{ $document->isOverdue() ? 'overdue' : '' }}">
                    {{ $document->isOverdue() ? $document->getDaysOverdue() . ' days' : 'No' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

