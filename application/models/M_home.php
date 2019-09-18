<?php
class M_home extends CI_Model{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function getAllNamaAkun()
    {
        $query=$this->db->get('jenisakun');
        $this->db->where('status','1');

        $jenisakun = array();
        foreach($query->result_array() as $row)
        {
            $jenisakun[$row['id']]=$row['nama'];
        }

        $this->db->order_by('id_jenisAkun', 'ASC');
        $queryNA = $this->db->get('namaakun');

        $jsondata='{';
        $x=0;
        $y=0;
        $idJA = 0;
        foreach($queryNA->result_array() as $row)
        {
            if($idJA != $row['id_jenisAkun'])
            {
                $y=0;
                $idJA = $row['id_jenisAkun'];
                if($x>0)
                {
                    $jsondata = $jsondata.'],';
                }

                $jsondata = $jsondata.'"'.$jenisakun[$row['id_jenisAkun']].'":[';
                
                $x++;
            }

            if($y>0)
            {
                $jsondata = $jsondata.',';
            }

            $jsondata = $jsondata.'{"id":"'.$row['id'].'", "akun":"'.$row['nama'].'"}';

            $y++;
        }

        $jsondata = $jsondata.']}';

        return $jsondata;
    }

    public function tambahJurnal($data)
    {
	// data = [akun][idAkun][ketAkun][debit][kredit][tanggal]	
	
	if($data['debit'] != 0) {
			$nominal = $data['debit']; 
			$jenisTransaksi = 0;
			}
	if($data['kredit'] != 0) {
			$nominal = $data['kredit']; 
			$jenisTransaksi = 1;
			}

        echo $data['debit'];

        $sql="insert into jurnal value('',".$data['idAkun'].",
		".$data['tanggal'].", ".$data['ketAkun'].", ".$nominal.", 
        ".$jenisTransaksi.", 0)";
        
        // $sql="insert into jurnal value('',1,
		// 2, 3, 4, 
		// 5, 0)";
      
        
        if($this->db->query($sql))
            echo 0;
        else
            echo 1;
			
    // tanggal , keterangan, debit, kredit 
	
    // id_jurnal, id_namaAkun, tanggal , keterangan, nominal, 
	//               jenis transaksi (isi : debit atau kredit), saldo  	
    }

}
?>
