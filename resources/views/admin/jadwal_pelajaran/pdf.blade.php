<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pelajaran</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
<h1>Jadwal Pelajaran</h1>
<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Kelas</th>
        <th>Hari</th>
        <th>Jam Mulai</th>
        <th>Jam Selesai</th>
        <th>Pelajaran</th>
        <th>Guru</th>
        <th>Ruang</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($jadwal_pelajaran as $index => $jadwal)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $jadwal->kelas->nama_kelas }}</td>
            <td>{{ $jadwal->hari }}</td>
            <td>{{ $jadwal->jam_mulai }}</td>
            <td>{{ $jadwal->jam_selesai }}</td>
            <td>{{ $jadwal->pelajaran->nama_pelajaran }}</td>
            <td>{{ $jadwal->guru->user->name }}</td>
            <td>{{ $jadwal->ruang->nama_ruang }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
