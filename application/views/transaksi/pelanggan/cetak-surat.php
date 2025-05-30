<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Terima</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.2;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .detail-content {
            background: white;
            border: 2px solid #000;
            padding: 15px;
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            gap: 15px;
        }

        .company-info {
            flex: 1;
            font-size: 12px;
            line-height: 1.3;
        }

        .company-info h3 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #000;
        }

        .card-title {
            flex: 0 0 200px;
            text-align: center;
            border: 1px solid #000;
            padding: 8px;
            background-color: #f0f0f0;
        }

        .card-title h2 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .card-title .doc-number {
            font-size: 12px;
            font-weight: bold;
        }

        .recipient-info {
            flex: 1;
            font-size: 12px;
            line-height: 1.4;
        }

        .recipient-info strong {
            font-weight: bold;
        }

        .nomor-MO {
            margin: 15px 0;
            padding: 8px;
            border: 1px solid #000;
            background-color: #f9f9f9;
            text-align: center;
        }

        .nomor-MO strong {
            font-weight: bold;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 12px;
        }

        th {
            background-color: #e0e0e0;
            font-weight: bold;
            padding: 6px 4px;
            border: 1px solid #000;
            text-align: center;
            font-size: 12px;
        }

        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
            vertical-align: middle;
        }

        td:first-child {
            text-align: center;
            width: 40px;
        }

        td:nth-child(2) {
            width: 80px;
            text-align: center;
        }

        td:nth-child(4) {
            text-align: center;
            font-size: 11px;
        }

        td:last-child {
            text-align: center;
            width: 60px;
        }

        .student-group {
            background-color: #f8f8f8;
        }

        .note {
            font-size: 11px;
            margin: 15px 0;
            padding: 8px 0;
            border-bottom: 1px solid #000;
            text-align: left;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 20px;
        }

        .signature-box {
            flex: 1;
            text-align: center;
            font-size: 12px;
        }

        .signature-box .title {
            margin-bottom: 40px;
            font-weight: bold;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            width: 120px;
            margin: 0 auto;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                gap: 10px;
            }

            .card-title {
                flex: none;
                width: 100%;
            }

            table {
                font-size: 11px;
            }

            th,
            td {
                padding: 3px 2px;
            }
        }
    </style>
</head>

<body>
    <div class="detail-content">
        <div class="card-header">
            <div class="company-info">
                <h3>PT TUNAS TUJU ASA</h3>
                Jl. KH. Mas Mansyur Kav. 35, Apt. Sudirman Park Lt. 1<br />
                AB/01/06-07, Karet Tengsin, Tanah Abang, Jakarta Pusat
            </div>
            <div class="card-title">
                <h2>TANDA TERIMA</h2>
                <div class="doc-number">No. TT/2505/003</div>
            </div>
            <div class="recipient-info">
                <strong>Tanggal:</strong> 2-May-2025<br />
                <strong>Kepada:</strong> KD3 - PT. Tunas Cahaya Kirana<br />
                <strong>Alamat:</strong> Jl. Siliwangi, KP. Rawa Panjang No. 110A<br />
                RT 002 RW 004, Sepanjang Jaya, Rawalumbu, Bekasi - Jawa Barat
            </div>
        </div>

        <div class="nomor-MO">
            <strong>Nomor MO: 001-006/IV/2024</strong>
        </div>

        <table>
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>KODE BARANG</th>
                    <th>NAMA BARANG</th>
                    <th>PAKET</th>
                    <th>NAMA SISWA</th>
                    <th>JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                <!-- Akhtara Ihsan -->
                <tr class="student-group">
                    <td>166</td>
                    <td>UF-BTK06</td>
                    <td>Kemeja Batik No.12</td>
                    <td>PAKET PRIMARY (SD)</td>
                    <td>Akhtara Ihsan</td>
                    <td>1 PCS</td>
                </tr>
                <tr class="student-group">
                    <td>167</td>
                    <td>UF-KTK06</td>
                    <td>Kemeja Kotak KF No.12</td>
                    <td>PAKET PRIMARY (SD)</td>
                    <td>Akhtara Ihsan</td>
                    <td>1 PCS</td>
                </tr>
                <tr class="student-group">
                    <td>168</td>
                    <td>UF-CLN05</td>
                    <td>Celana Dongker KF No.10</td>
                    <td>PAKET PRIMARY (SD)</td>
                    <td>Akhtara Ihsan</td>
                    <td>2 PCS</td>
                </tr>
                <tr class="student-group">
                    <td>169</td>
                    <td>UF-PE05</td>
                    <td>Seragam PE Putih KF No.10</td>
                    <td>PAKET PRIMARY (SD)</td>
                    <td>Akhtara Ihsan</td>
                    <td>1 STEL</td>
                </tr>
                <tr class="student-group">
                    <td>170</td>
                    <td>UF-PTH02</td>
                    <td>Kemeja Putih KF No.12</td>
                    <td>PAKET PRIMARY (SD)</td>
                    <td>Akhtara Ihsan</td>
                    <td>1 PCS</td>
                </tr>

                <!-- Rhaegan Ramadhan -->
                <tr>
                    <td>171</td>
                    <td>UF-BTK05</td>
                    <td>Kemeja Batik No.10</td>
                    <td>PAKET PRIMARY (SD)</td>
                    <td>Rhaegan Ramadhan</td>
                    <td>1 PCS</td>
                </tr>
                <tr>
                    <td>172</td>
                    <td>UF-KTK06</td>
                    <td>Kemeja Kotak KF No.10</td>
                    <td>PAKET PRIMARY (SD)</td>
                    <td>Rhaegan Ramadhan</td>
                    <td>1 PCS</td>
                </tr>
                <tr>
                    <td>173</td>
                    <td>UF-CLN05</td>
                    <td>Celana Dongker KF No.10</td>
                    <td>PAKET PRIMARY (SD)</td>
                    <td>Rhaegan Ramadhan</td>
                    <td>2 PCS</td>
                </tr>
                <tr>
                    <td>174</td>
                    <td>UF-PE04</td>
                    <td>Seragam PE Putih KF No.8</td>
                    <td>PAKET PRIMARY (SD)</td>
                    <td>Rhaegan Ramadhan</td>
                    <td>1 STEL</td>
                </tr>
                <tr>
                    <td>175</td>
                    <td>UF-PTH01</td>
                    <td>Kemeja Putih KF No.10</td>
                    <td>PAKET PRIMARY (SD)</td>
                    <td>Rhaegan Ramadhan</td>
                    <td>1 PCS</td>
                </tr>

                <!-- Kenneth Diramoti -->
                <tr class="student-group">
                    <td>176</td>
                    <td>UF-BTK06</td>
                    <td>Kemeja Batik No.16</td>
                    <td>PAKET PRIMARY (SD)</td>
                    <td>Kenneth Diramoti</td>
                    <td>1 PCS</td>
                </tr>
                <tr class="student-group">
                    <td>177</td>
                    <td>UF-KTK08</td>
                    <td>Kemeja Kotak KF No.16</td>
                    <td>PAKET PRIMARY (SD)</td>
                    <td>Kenneth Diramoti</td>
                    <td>1 PCS</td>
                </tr>
                <tr class="student-group">
                    <td>178</td>
                    <td>UF-CLN06</td>
                    <td>Celana Dongker KF No.16</td>
                    <td>PAKET PRIMARY (SD)</td>
                    <td>Kenneth Diramoti</td>
                    <td>2 PCS</td>
                </tr>
                <tr class="student-group">
                    <td>179</td>
                    <td>UF-PE07</td>
                    <td>Seragam PE Putih KF No.14</td>
                    <td>PAKET PRIMARY (SD)</td>
                    <td>Kenneth Diramoti</td>
                    <td>1 STEL</td>
                </tr>
                <tr class="student-group">
                    <td>180</td>
                    <td>UF-PTH04</td>
                    <td>Kemeja Putih KF No.16</td>
                    <td>PAKET PRIMARY (SD)</td>
                    <td>Kenneth Diramoti</td>
                    <td>1 PCS</td>
                </tr>
            </tbody>
        </table>

        <div class="note">
            Pastikan Barang yang diterima sudah sesuai. Batas Waktu Koreksi s.d Tanggal: ________
        </div>

        <div class="card-footer">
            <div class="signature-box">
                <div class="title">Diterima oleh,</div>
                <div class="signature-line"></div>
            </div>
            <div class="signature-box">
                <div class="title">Disiapkan oleh,</div>
                <div class="signature-line"></div>
            </div>
            <div class="signature-box">
                <div class="title">Disetujui oleh,</div>
                <div class="signature-line"></div>
            </div>
        </div>
    </div>
</body>

</html>