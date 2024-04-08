<?php

/**
 *
 */
use ClanCats\Hydrahon\Query\Expression as Ex;

class Controller
{
    public $Request;
    public $Data;
    public $Crud;
    public function __construct($Request)
    {
        $this->Crud = Crud::idupin();

        $this->Request = json_decode(json_encode($Request));
        $hal = $this->Request->hal;
        $this->$hal();

    }
    public function fields($tb)
    {

        return dd($this->Crud->getFields($tb)->toJson());
    }
    public function Login()
    {
        $data = [
            'judul' => 'Login',
            'path' => 'Login',
            'link' => 'Login',

        ];
        $Request = $this->Request;
        $this->Data = $data;
        if (isset($Request->login)) {
            $data['admin'] = collect($this->Crud->mysqli2->table('user')->select()->where('user', $Request->user)->where('pass', $Request->pass)->get());
            if ($data['admin']->isEmpty()) {
                echo "<script>alert('Maaf, Username atau Password yang anda inputkan salah');</script>";
                echo "<script>location.href = '?hal=Login';</script>";
                die();
            } else {
                $_SESSION['admin'] = $data['admin']->first();
                echo "<script>alert('Berhasil');</script>";
                echo "<script>location.href = '?hal=Home';</script>";
                die();
            }

        }
    }
    public function Logout()
    {
        session_destroy();
        echo "<script>alert('Berhasil');</script>";
        echo "<script>location.href = '?hal=Login';</script>";
        die();
    }

    public function Home()
    {
        $data = [
            'judul' => 'Home',
            'path' => 'Home',
            'link' => 'Home',

        ];
        $data['transaksi'] = collect($this->Crud->mysqli2->table('transaksi')->select()->get());

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->get())->map(function ($item, $key) use ($data) {
            $ts = $data['transaksi']->where('idbarang', $item->idbarang);
            $item->masuk = $ts->where('jenis', 'Masuk')->sum('qty');
            $item->keluar = $ts->where('jenis', 'Keluar')->sum('qty');

            $item->stok = $ts->where('jenis', 'Masuk')->sum('qty') - $ts->where('jenis', 'Keluar')->sum('qty');
            return $item;
        });

        $this->Data = $data;
    }
    public function User()
    {
        $data = [
            'judul' => 'Data User',
            'path' => 'Master/User',
            'induk' => 'Master',
            'link' => 'User',

        ];
        $fields1 = '[
                {"name":"user","label":"Username","type":"text","max":"10","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true},
                {"name":"pass","label":"Password","type":"password","max":"15","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":false},
                {"name":"nama","label":"Nama Lengkap","type":"text","max":"25","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true},
                {"name":"level","label":"Level Akses","type":"select","max":"15","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true}
                ]';
        $data['user'] = collect($this->Crud->mysqli2->table('user')->select()->get());

        $data['user.form'] = json_decode($fields1, true);

        $this->Data = $data;
    }
    public function Barang()
    {
        $data = [
            'judul' => 'Data Barang',
            'path' => 'Master/Barang',
            'induk' => 'Master',
            'link' => 'Barang',
        ];
        //$this->fields('barang');
        $fields1 = '[
                {"name":"merk","label":"Merk","type":"text","max":"15","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"deskripsi","label":"Deskripsi","type":"textarea","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"kategori","label":"Kategori","type":"text","max":"25","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data['barang.form'] = json_decode($fields1, true);

        $data['transaksi'] = collect($this->Crud->mysqli2->table('transaksi')->select()->get());

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->get())->map(function ($item, $key) use ($data) {
            $ts = $data['transaksi']->where('idbarang', $item->idbarang);
            $item->stok = $ts->where('jenis', 'Masuk')->sum('qty') - $ts->where('jenis', 'Keluar')->sum('qty');
            return $item;
        });

        $this->Data = $data;
    }
    public function Masuk()
    {
        $data = [
            'judul' => 'Data Barang Masuk',
            'path' => 'Transaksi/Masuk',
            'induk' => 'Transaksi',
            'link' => 'Masuk',
        ];
        $data['primary'] = 'idtransaksi';
        $data['table'] = 'transaksi';
        //$this->fields('transaksi');
        $fields1 = '[
               {"name":"idbarang","label":"Barang","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":false,"var":"input[]","var2":"tb[]"},
               {"name":"merk","label":"Merk","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"kategori","label":"Kategori","type":"text","max":"25","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"qty","label":"Qty","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"ket","label":"Keterangan","type":"text","max":"100","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data[$data['table'] . '.form'] = json_decode($fields1, true);
        $data['tgl'] = date('Y-m-d');

        if (isset($this->Request->tgl)) {
            $data['tgl'] = $this->Request->tgl;

        }
        $data[$data['table']] = collect($this->Crud->mysqli2->table($data['table'])->select()->join('barang', 'barang.idbarang', '=', 'transaksi.idbarang')->where('jenis', 'Masuk')->where('tgl', $data['tgl'])->get());
        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->get())->groupBy('kategori');

        $this->Data = $data;
    }
    public function Keluar()
    {
        $data = [
            'judul' => 'Data Barang Keluar',
            'path' => 'Transaksi/Keluar',
            'induk' => 'Transaksi',
            'link' => 'Keluar',
        ];
        //$this->fields('transaksi');
        $fields1 = '[
               {"name":"idbarang","label":"Barang","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":false,"var":"input[]","var2":"tb[]"},
               {"name":"merk","label":"Merk","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"kategori","label":"Kategori","type":"text","max":"25","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"qty","label":"Qty","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"ket","label":"Keterangan","type":"text","max":"100","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data['transaksi.form'] = json_decode($fields1, true);
        $data['tgl'] = date('Y-m-d');

        if (isset($this->Request->tgl)) {
            $data['tgl'] = $this->Request->tgl;

        }
        $data['transaksi'] = collect($this->Crud->mysqli2->table('transaksi')->select()->join('barang', 'barang.idbarang', '=', 'transaksi.idbarang')->where('jenis', 'Keluar')->where('tgl', $data['tgl'])->get());
        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->get())->groupBy('kategori');

        $this->Data = $data;
    }
    public function Inventaris()
    {
        $data = [
            'judul' => 'Laporan Inventaris',
            'path' => 'Laporan/Inventaris',
            'induk' => 'Laporan',
            'link' => 'Inventaris',
            'Request' => $this->Request,
        ];
        //$this->fields('transaksi');
        $fields1 = '[
               {"name":"merk","label":"Merk","type":"text","max":"15","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"deskripsi","label":"Deskripsi","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"kategori","label":"Kategori","type":"text","max":"25","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data['barang.form'] = json_decode($fields1, true);
        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->get());
        if (isset($data['Request']->tgl)) {
            //dd($data['Request']->tgl);
            //dd($data['Request']->jenis);
            $data['transaksi'] = $this->Crud->mysqli2->table('transaksi')->select(['barang.nama_barang', new Ex('month(tgl) as bln'), new Ex('year(tgl) as thn')])->join('barang', 'barang.idbarang', '=', 'transaksi.idbarang')->where(new Ex('year(tgl)'), $data['Request']->tgl[1]);
            //dd($data['transaksi']);
            if ($data['Request']->jenis == 'bulanan') {
                $data['transaksi'] = $data['transaksi']->where(new Ex('month(tgl)'), $data['Request']->tgl[0]);
                //dd($data['transaksi']);
            }
            $data['transaksi'] = collect($data['transaksi']->get());
        }

        $this->Data = $data;
    }  
    public function LapMasuk()
    {
        $data = [
            'judul' => 'Laporan Barang Masuk',
            'path' => 'Laporan/LapMasuk',
            'induk' => 'Laporan',
            'link' => 'LapMasuk',
            'Request' => $this->Request,
        ];
        //$this->fields('transaksi');
        $fields1 = '[
               {"name":"idbarang","label":"Barang","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":false,"var":"input[]","var2":"tb[]"},

               {"name":"merk","label":"Merk","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"kategori","label":"Kategori","type":"text","max":"25","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"qty","label":"Qty","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"ket","label":"Keterangan","type":"text","max":"100","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data['transaksi.form'] = json_decode($fields1, true);
        if (isset($data['Request']->tgl)) {
            $data['transaksi'] = $this->Crud->mysqli2->table('transaksi')->select(['barang.nama_barang','transaksi.tgl','barang.merk','barang.kategori','transaksi.qty','transaksi.ket', new Ex('month(tgl) as bln'), new Ex('year(tgl) as thn')])->join('barang', 'barang.idbarang', '=', 'transaksi.idbarang')->where('jenis', 'Masuk')->where(new Ex('year(tgl)'), $data['Request']->tgl[1]);
            if ($data['Request']->jenis == 'bulanan') {
                $data['transaksi'] = $data['transaksi']->where(new Ex('month(tgl)'), $data['Request']->tgl[0]);
            }
            $data['transaksi'] = collect($data['transaksi']->get())->sortBy('tgl');
        }

        $this->Data = $data;
    }
    public function LapKeluar()
    {
        $data = [
            'judul' => 'Laporan Barang Keluar',
            'path' => 'Laporan/LapKeluar',
            'induk' => 'Laporan',
            'link' => 'LapKeluar',
            'Request' => $this->Request,
        ];
        //$this->fields('transaksi');
        $fields1 = '[
               {"name":"idbarang","label":"Barang","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":false,"var":"input[]","var2":"tb[]"},

               {"name":"merk","label":"Merk","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"kategori","label":"Kategori","type":"text","max":"25","pnj":12,"val":null,"red":"","input":false,"up":false,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"qty","label":"Qty","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
               {"name":"ket","label":"Keterangan","type":"text","max":"100","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data['transaksi.form'] = json_decode($fields1, true);
        if (isset($data['Request']->tgl)) {
            $data['transaksi'] = $this->Crud->mysqli2->table('transaksi')->select(['barang.nama_barang','transaksi.tgl','barang.merk','barang.kategori','transaksi.qty','transaksi.ket', new Ex('month(tgl) as bln'), new Ex('year(tgl) as thn')])->join('barang', 'barang.idbarang', '=', 'transaksi.idbarang')->where('jenis', 'Keluar')->where(new Ex('year(tgl)'), $data['Request']->tgl[1]);
            if ($data['Request']->jenis == 'bulanan') {
                $data['transaksi'] = $data['transaksi']->where(new Ex('month(tgl)'), $data['Request']->tgl[0]);
            }
            $data['transaksi'] = collect($data['transaksi']->get())->sortBy('tgl');
        }

        $this->Data = $data;
    }
    public function Stok()
    {
        $data = [
            'judul' => 'Laporan Stok',
            'path' => 'Laporan/Stok',
            'induk' => 'Laporan',
            'link' => 'Stok',
            'Request' => $this->Request,
        ];
        //$this->fields('transaksi');
        $fields1 = '[
               {"name":"merk","label":"Merk","type":"text","max":"15","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"nama_barang","label":"Nama Barang","type":"text","max":"15","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"deskripsi","label":"Deskripsi","type":"number","max":null,"pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"},
                {"name":"kategori","label":"Kategori","type":"text","max":"25","pnj":12,"val":null,"red":"","input":true,"up":true,"tb":true,"var":"input[]","var2":"tb[]"}
                ]';
        $data['barang.form'] = json_decode($fields1, true);
        $data['transaksi'] = collect($this->Crud->mysqli2->table('transaksi')->select()->get());

        $data['barang'] = collect($this->Crud->mysqli2->table('barang')->select()->get())->map(function ($item, $key) use ($data) {
            $ts = $data['transaksi']->where('idbarang', $item->idbarang);
            $item->stok = $ts->where('jenis', 'Masuk')->sum('qty') - $ts->where('jenis', 'Keluar')->sum('qty');
            return $item;
        });

        $this->Data = $data;
    }

}
