
$('#tanggal').datetimepicker({
	lang:'en',
	timepicker:true,
	format:'Y-m-d H:i:s'
});

$('#tanggal_faktur').datetimepicker({
	lang:'en',
	timepicker:false,
	format:'Y-m-d'
});

$('#jatuh_tempo').datetimepicker({
	lang:'en',
	timepicker:false,
	format:'Y-m-d'
});

$(document).on('mouseup', '#id_pembayaran', function(){

	
	GantiStatus();
	
});

function GantiStatus()
{
	var Pembayaran = $('#id_pembayaran').val();

		if(Pembayaran > 1){
					var Status = "Belum Lunas";
					
				} else {
					var Status = "Lunas";
					
				}
		
		$('#Status').val(Status);
		

}

$(document).ready(function(){

	for(B=1; B<=1; B++){
		BarisBaru();
	}


	$('#id_supplier').change(function(){
		if($(this).val() !== '')
		{
			$.ajax({
				url: "https://apotikmahira.com/index.php/pembelian_depo2/ajax-supplier",
				type: "POST",
				cache: false,
				data: "id_supplier="+$(this).val(),
				dataType:'json',
				success: function(json){
					$('#no_pbf_supplier').html(json.no_pbf);
					$('#no_npwp_supplier').html(json.no_npwp);
					$('#top_supplier').html(json.top);
					$('#alamat_supplier').html(json.alamat);
					
				}
			});
		}
		else
		{
			$('#no_pbf_supplier').html('<small><i>Tidak ada</i></small>');
			$('#no_npwp_supplier').html('<small><i>Tidak ada</i></small>');
			$('#top_supplier').html('<small><i>Tidak ada</i></small>');
			$('#alamat_supplier').html('<small><i>Tidak ada</i></small>');
			
		}
	});

	
	$('#id_pelanggan').change(function(){
		if($(this).val() !== '')
		{
			$.ajax({
				url: "https://apotikmahira.com/index.php/penjualan_hamzah/ajax-pelanggan",
				type: "POST",
				cache: false,
				data: "id_pelanggan="+$(this).val(),
				dataType:'json',
				success: function(json){
					$('#telp_pelanggan').html(json.telp);
					$('#alamat_pelanggan').html(json.alamat);
					$('#info_tambahan_pelanggan').html(json.info_tambahan);
				}
			});
		}
		else
		{
			$('#telp_pelanggan').html('<small><i>Tidak ada</i></small>');
			$('#alamat_pelanggan').html('<small><i>Tidak ada</i></small>');
			$('#info_tambahan_pelanggan').html('<small><i>Tidak ada</i></small>');
		}
	});

	$('#BarisBaru').click(function(){
		BarisBaru();
	});

	$("#TabelTransaksi tbody").find('input[type=text],textarea,select').filter(':visible:first').focus();
});


function BarisBaru()
{
	var Nomor = $('#TabelTransaksi tbody tr').length + 1;
	var Baris = "<tr>";
		Baris += "<td>"+Nomor+"</td>";
		Baris += "<td>";
			Baris += "<input type='text' class='form-control' name='kode_barang[]' id='pencarian_kode' placeholder='Ketik Kode / Nama Barang'>";
			Baris += "<div id='hasil_pencarian'></div>";
		Baris += "</td>";
		Baris += "<td></td>";
		
		Baris += "<td>";
			Baris += "<input type='hidden' name='kategori[]'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td><input type='text' class='form-control' id='hna' name='hna[]' onkeypress='return check_int(event)' disabled></td>";
		Baris += "<td><input type='text' class='form-control' id='diskon' name='diskon[]' onkeypress='return check_int(event)' disabled></td>";
		Baris += "<td><input type='hidden' name='stok_awal[]'></td>";
		Baris += "<td><input type='text' class='form-control' id='jumlah_buy' name='jumlah_buy[]' onkeypress='return check_int(event)' disabled></td>";
		Baris += "<td></td>";
		Baris += "<td><input type='hidden' name='nilai[]'></td>";
		Baris += "<td><input type='text' class='form-control' id='jumlah_besar' name='jumlah_besar[]' onkeypress='return check_int(event)' disabled></td>";
		Baris += "<td></td>";
		Baris += "<td>";
			Baris += "<input type='hidden' name='hnappn[]'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td>";
			Baris += "<input type='hidden' name='hpokok[]'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td>";
			Baris += "<input type='hidden' name='hmodal[]'>";
			Baris += "<span></span>";
		Baris += "</td>";
		
		Baris += "<td><input type='hidden' name='r_resep[]'></td>";
		Baris += "<td><input type='text' class='form-control' id='hresep_a' name='hresep_a[]' onkeypress='return check_int(event)' disabled></td>";
		Baris += "<td><input type='hidden' name='r_bebas[]'></td>";
		Baris += "<td><input type='text' class='form-control' id='hbebas_a' name='hbebas_a[]' onkeypress='return check_int(event)' disabled></td>";
		Baris += "<td><input type='hidden' name='r_cash[]'></td>";
		Baris += "<td><input type='text' class='form-control' id='hd1_a' name='hd1_a[]' onkeypress='return check_int(event)' disabled></td>";
		Baris += "<td><input type='hidden' name='r_kredit[]'></td>";
		Baris += "<td><input type='text' class='form-control' id='hd2_a' name='hd2_a[]' onkeypress='return check_int(event)' disabled></td>";
		Baris += "<td><input type='hidden' name='r_cash_gro[]'></td>";
		Baris += "<td><input type='text' class='form-control' id='hcash' name='hcash[]' onkeypress='return check_int(event)' disabled></td>";
		Baris += "<td><input type='hidden' name='r_kredit_gro[]'></td>";
		Baris += "<td><input type='text' class='form-control' id='hkredit' name='hkredit[]' onkeypress='return check_int(event)' disabled></td>";
		

		Baris += "<td>";
			Baris += "<input type='hidden' name='sub_total[]'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td><button class='btn btn-default' id='HapusBaris'><i class='fa fa-times' style='color:red;'></i></button></td>";
		Baris += "</tr>";

	$('#TabelTransaksi tbody').append(Baris);

	$('#TabelTransaksi tbody tr').each(function(){
		$(this).find('td:nth-child(2) input').focus();
	});

	HitungTotalBayar();
	
}

$(document).on('click', '#HapusBaris', function(e){
	e.preventDefault();
	$(this).parent().parent().remove();

	var Nomor = 1;
	$('#TabelTransaksi tbody tr').each(function(){
		$(this).find('td:nth-child(1)').html(Nomor);
		Nomor++;
	});

	HitungTotalBayar();
});

function AutoCompleteGue(Lebar, KataKunci, Indexnya)
{
	$('div#hasil_pencarian').hide();
	var Lebar = Lebar + 55;

	var Registered = '';
	$('#TabelTransaksi tbody tr').each(function(){
		if(Indexnya !== $(this).index())
		{
			if($(this).find('td:nth-child(2) input').val() !== '')
			{
				Registered += $(this).find('td:nth-child(2) input').val() + ',';
			}
		}
	});

	if(Registered !== ''){
		Registered = Registered.replace(/,\s*$/,"");
	}

	$.ajax({
		url: "https://apotikmahira.com/index.php/pembelian_depo2/ajax-kode",
		type: "POST",
		cache: false,
		data:'keyword=' + KataKunci + '&registered=' + Registered,
		dataType:'json',
		success: function(json){
			if(json.status == 1)
			{
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').css({ 'width' : Lebar+'px' });
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').show('fast');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').html(json.datanya);
			}
			if(json.status == 0)
			{
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4)').html('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').prop('disabled', true).val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').prop('disabled', true).val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(7) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').prop('disabled', true).val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(9)').html('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(10) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(11) input').prop('disabled', true).val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(12)').html('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(14) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(15) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(16) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(17) input').prop('disabled', true).val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(18) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(19) input').prop('disabled', true).val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(20) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(21) input').prop('disabled', true).val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(22) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(23) input').prop('disabled', true).val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(24) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(25) input').prop('disabled', true).val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(26) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(27) input').prop('disabled', true).val('');	
				
			}
		}
	});

	HitungTotalBayar();
	
}

$(document).on('keyup', '#pencarian_kode', function(e){
	
	if($(this).val() !== '')
	{
		var charCode = e.which || e.keyCode;
		if(charCode == 40)
		{
			if($('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').length > 0)
			{
				var Selanjutnya = $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').next();
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').removeClass('autocomplete_active');

				Selanjutnya.addClass('autocomplete_active');
			}
			else
			{
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li:first').addClass('autocomplete_active');
			}
		} 
		else if(charCode == 38)
		{
			if($('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').length > 0)
			{
				var Sebelumnya = $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').prev();
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').removeClass('autocomplete_active');
			
				Sebelumnya.addClass('autocomplete_active');
			}
			else
			{
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li:first').addClass('autocomplete_active');
			}
		}
		else if(charCode == 13)
		{
			var Field = $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)');
			var Kodenya = Field.find('div#hasil_pencarian li.autocomplete_active span#kodenya').html();
			var Barangnya = Field.find('div#hasil_pencarian li.autocomplete_active span#barangnya').html();
			var Satuannya = Field.find('div#hasil_pencarian li.autocomplete_active span#satuannya').html();
			var Satuanbesar = Field.find('div#hasil_pencarian li.autocomplete_active span#satuanbesar').html();
			var Nilai = Field.find('div#hasil_pencarian li.autocomplete_active span#nilai').html();
			var Hnanya = Field.find('div#hasil_pencarian li.autocomplete_active span#hnanya').html();
			var Nasionalnya = Field.find('div#hasil_pencarian li.autocomplete_active span#nasionalnya').html();
			var Hpokoknya = Field.find('div#hasil_pencarian li.autocomplete_active span#hpokoknya').html();
			var Modalnya = Field.find('div#hasil_pencarian li.autocomplete_active span#modalnya').html();
			var Diskonbelinya = Field.find('div#hasil_pencarian li.autocomplete_active span#diskonbelinya').html();
			var Stokawalnya = Field.find('div#hasil_pencarian li.autocomplete_active span#stokawalnya').html();
			var Resepnya = Field.find('div#hasil_pencarian li.autocomplete_active span#resepnya').html();
			var Bebasnya = Field.find('div#hasil_pencarian li.autocomplete_active span#bebasnya').html();
			var Cashnya = Field.find('div#hasil_pencarian li.autocomplete_active span#cashnya').html();
			var Kreditnya = Field.find('div#hasil_pencarian li.autocomplete_active span#kreditnya').html();
			var Cash_gronya = Field.find('div#hasil_pencarian li.autocomplete_active span#cash_gronya').html();
			var Kredit_gronya = Field.find('div#hasil_pencarian li.autocomplete_active span#kredit_gronya').html();
			var Kategorinya = Field.find('div#hasil_pencarian li.autocomplete_active span#kategorinya').html();
			var R_resepnya = Field.find('div#hasil_pencarian li.autocomplete_active span#r_resepnya').html();
			var R_bebasnya = Field.find('div#hasil_pencarian li.autocomplete_active span#r_bebasnya').html();
			var R_cashnya = Field.find('div#hasil_pencarian li.autocomplete_active span#r_cashnya').html();
			var R_kreditnya = Field.find('div#hasil_pencarian li.autocomplete_active span#r_kreditnya').html();
			var R_cash_gronya = Field.find('div#hasil_pencarian li.autocomplete_active span#r_cash_gronya').html();
			var R_kredit_gronya = Field.find('div#hasil_pencarian li.autocomplete_active span#r_kredit_gronya').html();
			
			
			
			
			Field.find('div#hasil_pencarian').hide();
			Field.find('input').val(Kodenya);

			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(3)').html(Barangnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(4) input').val(Kategorinya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(4) span').html(Kategorinya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(5) input').removeAttr('disabled').val(Hnanya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(5) span').html(Hnanya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(6) input').removeAttr('disabled').val(Diskonbelinya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(6) span').html(Diskonbelinya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(7) input').val(Stokawalnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(8) input').removeAttr('disabled').val('');
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(9)').html(Satuannya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(10) input').val(Nilai);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(11) input').removeAttr('disabled').val('');
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(12)').html(Satuanbesar);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(13) input').val(Nasionalnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(13) span').html(Nasionalnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(14) input').val(Hpokoknya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(14) span').html(Hpokoknya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(15) input').val(Modalnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(15) span').html(Modalnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(16) input').val(R_resepnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(17) input').removeAttr('disabled').val(Resepnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(17) span').html(Resepnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(18) input').val(R_bebasnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(19) input').removeAttr('disabled').val(Bebasnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(19) span').html(Bebasnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(20) input').val(R_cashnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(21) input').removeAttr('disabled').val(Cashnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(21) span').html(Cashnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(22) input').val(R_kreditnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(23) input').removeAttr('disabled').val(Kreditnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(23) span').html(Kreditnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(24) input').val(R_cash_gronya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(25) input').removeAttr('disabled').val(Cash_gronya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(25) span').html(Cash_gronya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(26) input').val(R_kredit_gronya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(27) input').removeAttr('disabled').val(Kredit_gronya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(27) span').html(Kredit_gronya);	
			
			
			
			
			var IndexIni = $(this).parent().parent().index() + 1;
			var TotalIndex = $('#TabelTransaksi tbody tr').length;
			if(IndexIni == TotalIndex){
				BarisBaru();

				$('html, body').animate({ scrollTop: $(document).height() }, 0);
			}
			else {
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(5) input').focus();
			}
		}
		else 
		{
			AutoCompleteGue($(this).width(), $(this).val(), $(this).parent().parent().index());
		}
	}
	else
	{
		$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian').hide();
	}

	HitungTotalBayar();
	
});

$(document).on('click', '#daftar-autocomplete li', function(){
	$(this).parent().parent().parent().find('input').val($(this).find('span#kodenya').html());
	
	var Indexnya = $(this).parent().parent().parent().parent().index();
	var NamaBarang = $(this).find('span#barangnya').html();
	var Satuannya = $(this).find('span#satuannya').html();
	var Satuanbesar = $(this).find('span#satuanbesar').html();
	var Nilai = $(this).find('span#nilai').html();
	var Hnanya = $(this).find('span#hnanya').html();
	var Nasionalnya = $(this).find('span#nasionalnya').html();
	var Hpokoknya = $(this).find('span#hpokoknya').html();
	var Modalnya = $(this).find('span#modalnya').html();
	var Diskonbelinya = $(this).find('span#diskonbelinya').html();
	var Stokawalnya = $(this).find('span#stokawalnya').html();
	var Resepnya = $(this).find('span#resepnya').html();
	var Bebasnya = $(this).find('span#bebasnya').html();
	var Cashnya = $(this).find('span#cashnya').html();
	var Kreditnya = $(this).find('span#kreditnya').html();
	var Cash_gronya = $(this).find('span#cash_gronya').html();
	var Kredit_gronya = $(this).find('span#kredit_gronya').html();
	var Kategorinya = $(this).find('span#kategorinya').html();
	var R_resepnya = $(this).find('span#r_resepnya').html();
	var R_bebasnya = $(this).find('span#r_bebasnya').html();
	var R_cashnya = $(this).find('span#r_cashnya').html();
	var R_kreditnya = $(this).find('span#r_kreditnya').html();
	var R_cash_gronya = $(this).find('span#r_cash_gronya').html();
	var R_kredit_gronya = $(this).find('span#r_kredit_gronya').html();
	
	

	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(Kategorinya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(Kategorinya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(Hnanya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').removeAttr('disabled').val(Diskonbelinya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(7) input').val(Stokawalnya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').removeAttr('disabled').val('');
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(9)').html(Satuannya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(10) input').val(Nilai);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(11) input').removeAttr('disabled').val('');
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(12)').html(Satuanbesar);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) input').val(Nasionalnya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) span').html(Nasionalnya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(14) input').val(Hpokoknya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(14) span').html(Hpokoknya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(15) input').val(Modalnya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(15) span').html(Modalnya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(16) input').val(R_resepnya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(17) input').removeAttr('disabled').val(Resepnya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(18) input').val(R_bebasnya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(19) input').removeAttr('disabled').val(Bebasnya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(20) input').val(R_cashnya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(21) input').removeAttr('disabled').val(Cashnya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(22) input').val(R_kreditnya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(23) input').removeAttr('disabled').val(Kreditnya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(24) input').val(R_cash_gronya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(25) input').removeAttr('disabled').val(Cash_gronya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(26) input').val(R_kredit_gronya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(27) input').removeAttr('disabled').val(Kredit_gronya);
	
	
	
	
	

	var IndexIni = Indexnya + 1;
	var TotalIndex = $('#TabelTransaksi tbody tr').length;
	if(IndexIni == TotalIndex){
		BarisBaru();
		$('html, body').animate({ scrollTop: $(document).height() }, 0);
	}
	else {
		$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
	}

	HitungTotalBayar();

});

$(document).on('keyup', '#hna', function(){
	var Indexnya = $(this).parent().parent().index();
	var Kategori = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val();
	var R_resepnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(16) input').val();
	var Resepnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(17) input').val();
	var R_bebasnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(18) input').val();
	var Bebasnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(19) input').val();
	var R_cashnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(20) input').val();
	var Cashnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(21) input').val();
	var R_kreditnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(22) input').val();
	var Kreditnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(23) input').val();
	var R_cash_gronya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(24) input').val();
	var Cash_gronya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(25) input').val();
	var R_kredit_gronya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(26) input').val();
	var Kredit_gronya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(27) input').val();
	var Hnasional = $(this).val();
	var Nasional = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) input').val();
	var Pokok = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(14) input').val();
	var Modal = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(15) input').val();
	var Diskon = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val();
	var JumlahBuy = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').val();
	var JumlahBesar = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(11) input').val();
	var Nilai = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(10) input').val();
	var KodeBarang = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2) input').val();


$.ajax({
		url: "https://apotikmahira.com/index.php/barang/cek-harga_depo2",
		type: "POST",
		cache: false,
		data: "kode_barang="+encodeURI(KodeBarang)+"&modal="+Modal,
		dataType:'json',
		success: function(data){
			if(data.status == 1)
			{
				

					var DiscBeli = parseFloat(Hnasional) * parseFloat(Diskon) / 100
					var Pokok = parseFloat(Hnasional) - parseFloat(DiscBeli)
					var Ppnna = parseFloat(Pokok) * 11/100
					var Nasional = parseFloat(Hnasional) + parseFloat(Ppnna)
					var Modal = parseFloat(Pokok) + parseFloat(Ppnna);
					var SubTotal = parseFloat(Modal) * parseFloat(JumlahBuy);
					
					if (Kategori == 'Generik'){//generik 1//
						
							//Tipe A //
							var resA = parseFloat(Nasional) * parseFloat(R_resepnya) / 100
							var BebA = parseFloat(Nasional) * parseFloat(R_bebasnya) / 100
							var D1A = parseFloat(Nasional) * parseFloat(R_cashnya) / 100
							var D2A = parseFloat(Nasional) * parseFloat(R_kreditnya) / 100
							var CG = parseFloat(Nasional) * parseFloat(R_cash_gronya) / 100
							var KG = parseFloat(Nasional) * parseFloat(R_kredit_gronya) / 100
							
					
					var Hresep_a = parseFloat(Nasional) + parseFloat(resA);
					var Hbebas_a = parseFloat(Nasional) + parseFloat(BebA);
					var Hd1_a = parseFloat(Nasional) + parseFloat(D1A);
					var Hd2_a = parseFloat(Nasional) + parseFloat(D2A);
					var Hcash = parseFloat(Nasional) + parseFloat(CG);
					var Hkredit = parseFloat(Nasional) + parseFloat(KG);
					
					}

					else if (Kategori == 'Ethical'){//ethical 2//
					
							//Tipe A //
							var resA = parseFloat(Nasional) * parseFloat(R_resepnya) / 100
							var BebA = parseFloat(Nasional) * parseFloat(R_bebasnya) / 100
							var D1A = parseFloat(Nasional) * parseFloat(R_cashnya) / 100
							var D2A = parseFloat(Nasional) * parseFloat(R_kreditnya) / 100
							var CG = parseFloat(Nasional) * parseFloat(R_cash_gronya) / 100
							var KG = parseFloat(Nasional) * parseFloat(R_kredit_gronya) / 100
							
					
					var Hresep_a = parseFloat(Nasional) + parseFloat(resA);
					var Hbebas_a = parseFloat(Nasional) + parseFloat(BebA);
					var Hd1_a = parseFloat(Nasional) + parseFloat(D1A);
					var Hd2_a = parseFloat(Nasional) + parseFloat(D2A);
					var Hcash = parseFloat(Nasional) + parseFloat(CG);
					var Hkredit = parseFloat(Nasional) + parseFloat(KG);
					
					}
					

					else if (Kategori == 'Alkes'){//alkes 3//
					//Tipe A //
					var resA = parseFloat(Modal) * parseFloat(R_resepnya) / 100
					var BebA = parseFloat(Modal) * parseFloat(R_bebasnya) / 100
					var D1A = parseFloat(Modal) * parseFloat(R_cashnya) / 100
					var D2A = parseFloat(Modal) * parseFloat(R_kreditnya) / 100
					var CG = parseFloat(Modal) * parseFloat(R_cash_gronya) / 100
					var KG = parseFloat(Modal) * parseFloat(R_kredit_gronya) / 100
					
					var Hresep_a = parseFloat(Modal) + parseFloat(resA);
					var Hbebas_a = parseFloat(Modal) + parseFloat(BebA);
					var Hd1_a = parseFloat(Modal) + parseFloat(D1A);
					var Hd2_a = parseFloat(Modal) + parseFloat(D2A);
					var Hcash = parseFloat(Modal) + parseFloat(CG);
					var Hkredit = parseFloat(Modal) + parseFloat(KG);
					
					}

					else if (Kategori == 'Herbal'){//herbal 4//
					//Tipe A //
					var resA = parseFloat(Modal) * parseFloat(R_resepnya) / 100
					var BebA = parseFloat(Modal) * parseFloat(R_bebasnya) / 100
					var D1A = parseFloat(Modal) * parseFloat(R_cashnya) / 100
					var D2A = parseFloat(Modal) * parseFloat(R_kreditnya) / 100
					var CG = parseFloat(Modal) * parseFloat(R_cash_gronya) / 100
					var KG = parseFloat(Modal) * parseFloat(R_kredit_gronya) / 100
					
					var Hresep_a = parseFloat(Modal) + parseFloat(resA);
					var Hbebas_a = parseFloat(Modal) + parseFloat(BebA);
					var Hd1_a = parseFloat(Modal) + parseFloat(D1A);
					var Hd2_a = parseFloat(Modal) + parseFloat(D2A);
					var Hcash = parseFloat(Modal) + parseFloat(CG);
					var Hkredit = parseFloat(Modal) + parseFloat(KG);
					
					}

					else if (Kategori == 'Olahan'){//olahan 5//
					
					var Hresep_a = parseFloat(Resepnya);
					var Hbebas_a = parseFloat(Bebasnya);
					var Hd1_a = parseFloat(Cashnya);
					var Hd2_a = parseFloat(Kreditnya);
					var Hcash = parseFloat(Cash_gronya);
					var Hkredit = parseFloat(Kredit_gronya);
					
					}

					

					else if (Kategori == 'OTC'){//OTC 6//
					
						
							//Tipe A //
							var resA = parseFloat(Nasional) * parseFloat(R_resepnya) / 100
							var BebA = parseFloat(Nasional) * parseFloat(R_bebasnya) / 100
							var D1A = parseFloat(Nasional) * parseFloat(R_cashnya) / 100
							var D2A = parseFloat(Nasional) * parseFloat(R_kreditnya) / 100
							var CG = parseFloat(Nasional) * parseFloat(R_cash_gronya) / 100
							var KG = parseFloat(Nasional) * parseFloat(R_kredit_gronya) / 100
							
					
					
					var Hresep_a = parseFloat(Nasional) + parseFloat(resA);
					var Hbebas_a = parseFloat(Nasional) + parseFloat(BebA);
					var Hd1_a = parseFloat(Nasional) + parseFloat(D1A);
					var Hd2_a = parseFloat(Nasional) + parseFloat(D2A);
					var Hcash = parseFloat(Nasional) + parseFloat(CG);
					var Hkredit = parseFloat(Nasional) + parseFloat(KG);
					
					}


					else if (Kategori == 'Trading'){//trading 7//
					
					
							//Tipe A //
							var resA = parseFloat(Modal) * parseFloat(R_resepnya) / 100
							var BebA = parseFloat(Modal) * parseFloat(R_bebasnya) / 100
							var D1A = parseFloat(Modal) * parseFloat(R_cashnya) / 100
							var D2A = parseFloat(Modal) * parseFloat(R_kreditnya) / 100
							var CG = parseFloat(Modal) * parseFloat(R_cash_gronya) / 100
							var KG = parseFloat(Modal) * parseFloat(R_kredit_gronya) / 100
							
						
					
					
					var Hresep_a = parseFloat(Modal) + parseFloat(resA);
					var Hbebas_a = parseFloat(Modal) + parseFloat(BebA);
					var Hd1_a = parseFloat(Modal) + parseFloat(D1A);
					var Hd2_a = parseFloat(Modal) + parseFloat(D2A);
					var Hcash = parseFloat(Modal) + parseFloat(CG);
					var Hkredit = parseFloat(Modal) + parseFloat(KG);
					
					}
				


				
				
				if(Nasional > -1){
					var NasionalVal = Nasional;
					Nasional = Nasional.toFixed(0);
					var PokokVal = Pokok;
					Pokok = Pokok.toFixed(0);
					var ModalVal = Modal;
					Modal = Modal.toFixed(0);
					var Hresep_aVal = Hresep_a;
					Hresep_a = Hresep_a.toFixed(0);
					var Hbebas_aVal = Hbebas_a;
					Hbebas_a = Hbebas_a.toFixed(0);
					var Hd1_aVal = Hd1_a;
					Hd1_a = Hd1_a.toFixed(0);
					var Hd2_aVal = Hd2_a;
					Hd2_a = Hd2_a.toFixed(0);
					var HcashVal = Hcash;
					Hcash = Hcash.toFixed(0);
					var HkreditVal = Hkredit;
					Hkredit = Hkredit.toFixed(0);
					
					
				}
				 else {
					var NasionalVal = '';
					Nasional = 0;
					var PokokVal = '';
					Pokok = 0;
					var ModalVal = '';
					Modal = 0;
					var Hresep_aVal = '';
					Hresep_a = 0;
					var Hbebas_aVal = '';
					Hbebas_a = 0;
					var Hd1_aVal = '';
					Hd1_a = 0;
					var Hd2_aVal = '';
					Hd2_a = 0;
					var HcashVal = '';
					Hcash = 0;
					var HkreditVal = '';
					Hkredit = 0;
					
				}

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) input').val(NasionalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) span').html(Nasional);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(14) input').val(PokokVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(14) span').html(Pokok);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(15) input').val(ModalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(15) span').html(Modal);
				
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(17) input').val(Hresep_aVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(17) span').html(Hresep_a);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(19) input').val(Hbebas_aVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(19) span').html(Hbebas_a);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(21) input').val(Hd1_aVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(21) span').html(Hd1_a);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(23) input').val(Hd2_aVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(23) span').html(Hd2_a);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(25) input').val(HcashVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(25) span').html(Hcash);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(27) input').val(HkreditVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(27) span').html(Hkredit);
				
				
			}
			if(data.status == 0)
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok, Saya Mengerti</button>");
				$('#ModalGue').modal('show');

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').val('');
			}
		}
	});

	$.ajax({
		url: "https://apotikmahira.com/index.php/barang/cek-stok2_hamzah",
		type: "POST",
		cache: false,
		data: "kode_barang="+encodeURI(KodeBarang)+"&stok_hamzah="+JumlahBuy,
		dataType:'json',
		success: function(data){
			if(data.status == 1)
			{

				var DiscBeli = parseFloat(Hnasional) * parseFloat(Diskon) / 100
				var Pokok = parseFloat(Hnasional) - parseFloat(DiscBeli)
				var Ppnna = parseFloat(Pokok) * 11/100
				var Nasional = parseFloat(Hnasional) + parseFloat(Ppnna)
			
				var Modal = parseFloat(Pokok) + parseFloat(Ppnna);
		
				var SubTotal = parseFloat(Modal) * parseFloat(JumlahBuy);
				if(Nasional > -1){
					var SubTotalVal = SubTotal;
					SubTotal = SubTotal.toFixed(0);
				} else {
					SubTotal = '';
					var SubTotalVal = 0;
				}

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(28) input').val(SubTotalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(28) span').html(SubTotal);
				HitungTotalBayar();
			}
			if(data.status == 0)
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok, Saya Mengerti</button>");
				$('#ModalGue').modal('show');

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').val('');
			}
		}
	});
});
	

$(document).on('keydown', '#hna', function(e){
	var charCode = e.which || e.keyCode;
	if(charCode == 9){
		var Indexnya = $(this).parent().parent().index() + 1;
		var TotalIndex = $('#TabelTransaksi tbody tr').length;
		if(Indexnya == TotalIndex){
			BarisBaru();
			return false;
		}
	}
	HitungTotalBayar();
	
});

$(document).on('keyup', '#diskon', function(){
	var Indexnya = $(this).parent().parent().index();
	var Kategori = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val();
	var R_resepnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(16) input').val();
	var Resepnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(17) input').val();
	var R_bebasnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(18) input').val();
	var Bebasnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(19) input').val();
	var R_cashnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(20) input').val();
	var Cashnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(21) input').val();
	var R_kreditnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(22) input').val();
	var Kreditnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(23) input').val();
	var R_cash_gronya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(24) input').val();
	var Cash_gronya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(25) input').val();
	var R_kredit_gronya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(26) input').val();
	var Kredit_gronya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(27) input').val();
	var Hnasional = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').val();
	var Nasional = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) input').val();
	var Pokok = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(14) input').val();
	var Modal = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(15) input').val();
	var Diskon = $(this).val();
	var JumlahBuy = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').val();
	var JumlahBesar = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(11) input').val();
	var Nilai = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(10) input').val();
	var KodeBarang = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2) input').val();

	

	$.ajax({
		url: "https://apotikmahira.com/index.php/barang/cek-harga_depo2",
		type: "POST",
		cache: false,
		data: "kode_barang="+encodeURI(KodeBarang)+"&modal="+Modal,
		dataType:'json',
		success: function(data){
			if(data.status == 1)
			{
				

					var DiscBeli = parseFloat(Hnasional) * parseFloat(Diskon) / 100
					var Pokok = parseFloat(Hnasional) - parseFloat(DiscBeli)
					var Ppnna = parseFloat(Pokok) * 11/100
					var Nasional = parseFloat(Hnasional) + parseFloat(Ppnna)
					var Modal = parseFloat(Pokok) + parseFloat(Ppnna);
					var SubTotal = parseFloat(Modal) * parseFloat(JumlahBuy);
					
					if (Kategori == 'Generik'){//generik 1//
						
							//Tipe A //
							var resA = parseFloat(Nasional) * parseFloat(R_resepnya) / 100
							var BebA = parseFloat(Nasional) * parseFloat(R_bebasnya) / 100
							var D1A = parseFloat(Nasional) * parseFloat(R_cashnya) / 100
							var D2A = parseFloat(Nasional) * parseFloat(R_kreditnya) / 100
							var CG = parseFloat(Nasional) * parseFloat(R_cash_gronya) / 100
							var KG = parseFloat(Nasional) * parseFloat(R_kredit_gronya) / 100
							
					
					var Hresep_a = parseFloat(Nasional) + parseFloat(resA);
					var Hbebas_a = parseFloat(Nasional) + parseFloat(BebA);
					var Hd1_a = parseFloat(Nasional) + parseFloat(D1A);
					var Hd2_a = parseFloat(Nasional) + parseFloat(D2A);
					var Hcash = parseFloat(Nasional) + parseFloat(CG);
					var Hkredit = parseFloat(Nasional) + parseFloat(KG);
					
					}

					else if (Kategori == 'Ethical'){//ethical 2//
					
							//Tipe A //
							var resA = parseFloat(Nasional) * parseFloat(R_resepnya) / 100
							var BebA = parseFloat(Nasional) * parseFloat(R_bebasnya) / 100
							var D1A = parseFloat(Nasional) * parseFloat(R_cashnya) / 100
							var D2A = parseFloat(Nasional) * parseFloat(R_kreditnya) / 100
							var CG = parseFloat(Nasional) * parseFloat(R_cash_gronya) / 100
							var KG = parseFloat(Nasional) * parseFloat(R_kredit_gronya) / 100
							
					
					var Hresep_a = parseFloat(Nasional) + parseFloat(resA);
					var Hbebas_a = parseFloat(Nasional) + parseFloat(BebA);
					var Hd1_a = parseFloat(Nasional) + parseFloat(D1A);
					var Hd2_a = parseFloat(Nasional) + parseFloat(D2A);
					var Hcash = parseFloat(Nasional) + parseFloat(CG);
					var Hkredit = parseFloat(Nasional) + parseFloat(KG);
					
					}
					

					else if (Kategori == 'Alkes'){//alkes 3//
					//Tipe A //
					var resA = parseFloat(Modal) * parseFloat(R_resepnya) / 100
					var BebA = parseFloat(Modal) * parseFloat(R_bebasnya) / 100
					var D1A = parseFloat(Modal) * parseFloat(R_cashnya) / 100
					var D2A = parseFloat(Modal) * parseFloat(R_kreditnya) / 100
					var CG = parseFloat(Modal) * parseFloat(R_cash_gronya) / 100
					var KG = parseFloat(Modal) * parseFloat(R_kredit_gronya) / 100
					
					var Hresep_a = parseFloat(Modal) + parseFloat(resA);
					var Hbebas_a = parseFloat(Modal) + parseFloat(BebA);
					var Hd1_a = parseFloat(Modal) + parseFloat(D1A);
					var Hd2_a = parseFloat(Modal) + parseFloat(D2A);
					var Hcash = parseFloat(Modal) + parseFloat(CG);
					var Hkredit = parseFloat(Modal) + parseFloat(KG);
					
					}

					else if (Kategori == 'Herbal'){//herbal 4//
					//Tipe A //
					var resA = parseFloat(Modal) * parseFloat(R_resepnya) / 100
					var BebA = parseFloat(Modal) * parseFloat(R_bebasnya) / 100
					var D1A = parseFloat(Modal) * parseFloat(R_cashnya) / 100
					var D2A = parseFloat(Modal) * parseFloat(R_kreditnya) / 100
					var CG = parseFloat(Modal) * parseFloat(R_cash_gronya) / 100
					var KG = parseFloat(Modal) * parseFloat(R_kredit_gronya) / 100
					
					var Hresep_a = parseFloat(Modal) + parseFloat(resA);
					var Hbebas_a = parseFloat(Modal) + parseFloat(BebA);
					var Hd1_a = parseFloat(Modal) + parseFloat(D1A);
					var Hd2_a = parseFloat(Modal) + parseFloat(D2A);
					var Hcash = parseFloat(Modal) + parseFloat(CG);
					var Hkredit = parseFloat(Modal) + parseFloat(KG);
					
					}

					else if (Kategori == 'Olahan'){//olahan 5//
					
					var Hresep_a = parseFloat(Resepnya);
					var Hbebas_a = parseFloat(Bebasnya);
					var Hd1_a = parseFloat(Cashnya);
					var Hd2_a = parseFloat(Kreditnya);
					var Hcash = parseFloat(Cash_gronya);
					var Hkredit = parseFloat(Kredit_gronya);
					
					}

					

					else if (Kategori == 'OTC'){//OTC 6//
					
						
							//Tipe A //
							var resA = parseFloat(Nasional) * parseFloat(R_resepnya) / 100
							var BebA = parseFloat(Nasional) * parseFloat(R_bebasnya) / 100
							var D1A = parseFloat(Nasional) * parseFloat(R_cashnya) / 100
							var D2A = parseFloat(Nasional) * parseFloat(R_kreditnya) / 100
							var CG = parseFloat(Nasional) * parseFloat(R_cash_gronya) / 100
							var KG = parseFloat(Nasional) * parseFloat(R_kredit_gronya) / 100
							
					
					
					var Hresep_a = parseFloat(Nasional) + parseFloat(resA);
					var Hbebas_a = parseFloat(Nasional) + parseFloat(BebA);
					var Hd1_a = parseFloat(Nasional) + parseFloat(D1A);
					var Hd2_a = parseFloat(Nasional) + parseFloat(D2A);
					var Hcash = parseFloat(Nasional) + parseFloat(CG);
					var Hkredit = parseFloat(Nasional) + parseFloat(KG);
					
					}


					else if (Kategori == 'Trading'){//trading 7//
					
					
							//Tipe A //
							var resA = parseFloat(Modal) * parseFloat(R_resepnya) / 100
							var BebA = parseFloat(Modal) * parseFloat(R_bebasnya) / 100
							var D1A = parseFloat(Modal) * parseFloat(R_cashnya) / 100
							var D2A = parseFloat(Modal) * parseFloat(R_kreditnya) / 100
							var CG = parseFloat(Modal) * parseFloat(R_cash_gronya) / 100
							var KG = parseFloat(Modal) * parseFloat(R_kredit_gronya) / 100
							
						
					
					
					var Hresep_a = parseFloat(Modal) + parseFloat(resA);
					var Hbebas_a = parseFloat(Modal) + parseFloat(BebA);
					var Hd1_a = parseFloat(Modal) + parseFloat(D1A);
					var Hd2_a = parseFloat(Modal) + parseFloat(D2A);
					var Hcash = parseFloat(Modal) + parseFloat(CG);
					var Hkredit = parseFloat(Modal) + parseFloat(KG);
					
					}
				


				
				
				if(Nasional > -1){
					var NasionalVal = Nasional;
					Nasional = Nasional.toFixed(0);
					var PokokVal = Pokok;
					Pokok = Pokok.toFixed(0);
					var ModalVal = Modal;
					Modal = Modal.toFixed(0);
					var Hresep_aVal = Hresep_a;
					Hresep_a = Hresep_a.toFixed(0);
					var Hbebas_aVal = Hbebas_a;
					Hbebas_a = Hbebas_a.toFixed(0);
					var Hd1_aVal = Hd1_a;
					Hd1_a = Hd1_a.toFixed(0);
					var Hd2_aVal = Hd2_a;
					Hd2_a = Hd2_a.toFixed(0);
					var HcashVal = Hcash;
					Hcash = Hcash.toFixed(0);
					var HkreditVal = Hkredit;
					Hkredit = Hkredit.toFixed(0);
					
					
				}
				 else {
					var NasionalVal = '';
					Nasional = 0;
					var PokokVal = '';
					Pokok = 0;
					var ModalVal = '';
					Modal = 0;
					var Hresep_aVal = '';
					Hresep_a = 0;
					var Hbebas_aVal = '';
					Hbebas_a = 0;
					var Hd1_aVal = '';
					Hd1_a = 0;
					var Hd2_aVal = '';
					Hd2_a = 0;
					var HcashVal = '';
					Hcash = 0;
					var HkreditVal = '';
					Hkredit = 0;
					
				}

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) input').val(NasionalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) span').html(Nasional);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(14) input').val(PokokVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(14) span').html(Pokok);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(15) input').val(ModalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(15) span').html(Modal);
				
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(17) input').val(Hresep_aVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(17) span').html(Hresep_a);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(19) input').val(Hbebas_aVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(19) span').html(Hbebas_a);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(21) input').val(Hd1_aVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(21) span').html(Hd1_a);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(23) input').val(Hd2_aVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(23) span').html(Hd2_a);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(25) input').val(HcashVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(25) span').html(Hcash);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(27) input').val(HkreditVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(27) span').html(Hkredit);
				
			}
			if(data.status == 0)
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok, Saya Mengerti</button>");
				$('#ModalGue').modal('show');

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val('');
			}
		}
	});

	$.ajax({
		url: "https://apotikmahira.com/index.php/barang/cek-stok2_hamzah",
		type: "POST",
		cache: false,
		data: "kode_barang="+encodeURI(KodeBarang)+"&stok_hamzah="+JumlahBuy,
		dataType:'json',
		success: function(data){
			if(data.status == 1)
			{

				var DiscBeli = parseFloat(Hnasional) * parseFloat(Diskon) / 100
				var Pokok = parseFloat(Hnasional) - parseFloat(DiscBeli)
				var Ppnna = parseFloat(Pokok) * 11/100
				var Nasional = parseFloat(Hnasional) + parseFloat(Ppnna)
				
				var Modal = parseFloat(Pokok) + parseFloat(Ppnna);
			
				var SubTotal = parseFloat(Modal) * parseFloat(JumlahBuy);
				if(Nasional > -1){
					var SubTotalVal = SubTotal;
					SubTotal = SubTotal.toFixed(0);
				} else {
					SubTotal = '';
					var SubTotalVal = 0;
				}

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(28) input').val(SubTotalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(28) span').html(SubTotal);
				HitungTotalBayar();
			}
			if(data.status == 0)
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok, Saya Mengerti</button>");
				$('#ModalGue').modal('show');

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val('');
			}
		}
	});
});


$(document).on('keydown', '#diskon', function(e){
	var charCode = e.which || e.keyCode;
	if(charCode == 9){
		var Indexnya = $(this).parent().parent().index() + 1;
		var TotalIndex = $('#TabelTransaksi tbody tr').length;
		if(Indexnya == TotalIndex){
			BarisBaru();
			return false;
		}
	}

	HitungTotalBayar();
});

$(document).on('keyup', '#jumlah_buy', function(){
	var Indexnya = $(this).parent().parent().index();
	var Kategori = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val();
	var R_resepnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(16) input').val();
	var Resepnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(17) input').val();
	var R_bebasnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(18) input').val();
	var Bebasnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(19) input').val();
	var R_cashnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(20) input').val();
	var Cashnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(21) input').val();
	var R_kreditnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(22) input').val();
	var Kreditnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(23) input').val();
	var R_cash_gronya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(24) input').val();
	var Cash_gronya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(25) input').val();
	var R_kredit_gronya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(26) input').val();
	var Kredit_gronya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(27) input').val();
	var Hnasional = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').val();
	var Nasional = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) input').val();
	var Pokok = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(14) input').val();
	var Modal = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(15) input').val();
	var Diskon = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val();
	var JumlahBuy = $(this).val();
	var JumlahBesar = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(11) input').val();
	var Nilai = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(10) input').val();	
	var KodeBarang = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2) input').val();

	$.ajax({
		url: "https://apotikmahira.com/index.php/barang/cek-harga_depo2",
		type: "POST",
		cache: false,
		data: "kode_barang="+encodeURI(KodeBarang)+"&modal="+Modal,
		dataType:'json',
		success: function(data){
			if(data.status == 1)
			{
				if(Nilai > 0)
				{
					var JumlahBesar =  parseFloat(JumlahBuy) / parseFloat(Nilai);
				}
				else {
					var JumlahBesar = 0;
				}
				

					var DiscBeli = parseFloat(Hnasional) * parseFloat(Diskon) / 100
					var Pokok = parseFloat(Hnasional) - parseFloat(DiscBeli)
					var Ppnna = parseFloat(Pokok) * 11/100
					var Nasional = parseFloat(Hnasional) + parseFloat(Ppnna)
					var Modal = parseFloat(Pokok) + parseFloat(Ppnna);
					var SubTotal = parseFloat(Modal) * parseFloat(JumlahBuy);
					
				if(Nasional > -1){
					var JumlahBesarVal = JumlahBesar;
					JumlahBesar = JumlahBesar.toFixed(0);
					var NasionalVal = Nasional;
					Nasional = Nasional.toFixed(0);
					var PokokVal = Pokok;
					Pokok = Pokok.toFixed(0);
					var ModalVal = Modal;
					Modal = Modal.toFixed(0);	
				}

				 else {
					var NasionalVal = '';
					Nasional = 0;
					var PokokVal = '';
					Pokok = 0;
					var ModalVal = '';
					Modal = 0;
				}

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(11) input').val(JumlahBesarVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(11) span').html(JumlahBesar);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) input').val(NasionalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) span').html(Nasional);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(14) input').val(PokokVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(14) span').html(Pokok);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(15) input').val(ModalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(15) span').html(Modal);
				
				
			}
			if(data.status == 0)
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok, Saya Mengerti</button>");
				$('#ModalGue').modal('show');

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').val('');
			}
		}
	});

	$.ajax({
		url: "https://apotikmahira.com/index.php/barang/cek-stok2_hamzah",
		type: "POST",
		cache: false,
		data: "kode_barang="+encodeURI(KodeBarang)+"&stok_hamzah="+JumlahBuy,
		dataType:'json',
		success: function(data){
			if(data.status == 1)
			{

				var DiscBeli = parseFloat(Hnasional) * parseFloat(Diskon) / 100
				var Pokok = parseFloat(Hnasional) - parseFloat(DiscBeli)
				var Ppnna = parseFloat(Pokok) * 11/100
				var Nasional = parseFloat(Hnasional) + parseFloat(Ppnna)
				
				var Modal = parseFloat(Pokok) + parseFloat(Ppnna);
					
				var SubTotal = parseFloat(Modal) * parseFloat(JumlahBuy);
				if(Nasional > -1){
					var SubTotalVal = SubTotal;
					SubTotal = SubTotal.toFixed(0);
				} else {
					SubTotal = '';
					var SubTotalVal = 0;
				}

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(28) input').val(SubTotalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(28) span').html(SubTotal);
				HitungTotalBayar();
			}
			if(data.status == 0)
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok, Saya Mengerti</button>");
				$('#ModalGue').modal('show');

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').val('');
			}
		}
	});
});

$(document).on('keydown', '#jumlah_buy', function(e){
	var charCode = e.which || e.keyCode;
	if(charCode == 9){
		var Indexnya = $(this).parent().parent().index() + 1;
		var TotalIndex = $('#TabelTransaksi tbody tr').length;
		if(Indexnya == TotalIndex){
			BarisBaru();
			return false;
		}
	}

	HitungTotalBayar();
});

$(document).on('keyup', '#jumlah_besar', function(){
	var Indexnya = $(this).parent().parent().index();
	var Kategori = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val();
	var R_resepnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(16) input').val();
	var Resepnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(17) input').val();
	var R_bebasnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(18) input').val();
	var Bebasnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(19) input').val();
	var R_cashnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(20) input').val();
	var Cashnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(21) input').val();
	var R_kreditnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(22) input').val();
	var Kreditnya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(23) input').val();
	var R_cash_gronya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(24) input').val();
	var Cash_gronya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(25) input').val();
	var R_kredit_gronya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(26) input').val();
	var Kredit_gronya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(27) input').val();
	var Hnasional = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').val();
	var Nasional = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) input').val();
	var Pokok = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(14) input').val();
	var Modal = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(15) input').val();
	var Diskon = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val();
	var JumlahBuy = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').val();
	var JumlahBesar = $(this).val();
	var Nilai = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(10) input').val();	
	var KodeBarang = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2) input').val();

	$.ajax({
		url: "https://apotikmahira.com/index.php/barang/cek-harga_depo2",
		type: "POST",
		cache: false,
		data: "kode_barang="+encodeURI(KodeBarang)+"&modal="+Modal,
		dataType:'json',
		success: function(data){
			if(data.status == 1)
			{
				if(Nilai > 0)
				{
					var JumlahBuy =  parseFloat(JumlahBesar) * parseFloat(Nilai);
				}
				else {
					var JumlahBuy = 0;
				}
				

					var DiscBeli = parseFloat(Hnasional) * parseFloat(Diskon) / 100
					var Pokok = parseFloat(Hnasional) - parseFloat(DiscBeli)
					var Ppnna = parseFloat(Pokok) * 11/100
					var Nasional = parseFloat(Hnasional) + parseFloat(Ppnna)
					var Modal = parseFloat(Pokok) + parseFloat(Ppnna);
					var SubTotal = parseFloat(Modal) * parseFloat(JumlahBuy);
					
				if(Nasional > -1){
					var JumlahBuyVal = JumlahBuy;
					JumlahBuy = JumlahBuy.toFixed(0);
					var NasionalVal = Nasional;
					Nasional = Nasional.toFixed(0);
					var PokokVal = Pokok;
					Pokok = Pokok.toFixed(0);
					var ModalVal = Modal;
					Modal = Modal.toFixed(0);	
				}

				 else {
					var NasionalVal = '';
					Nasional = 0;
					var PokokVal = '';
					Pokok = 0;
					var ModalVal = '';
					Modal = 0;
				}

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').val(JumlahBuyVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) span').html(JumlahBuy);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) input').val(NasionalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) span').html(Nasional);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(14) input').val(PokokVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(14) span').html(Pokok);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(15) input').val(ModalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(15) span').html(Modal);
				
				
			}
			if(data.status == 0)
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok, Saya Mengerti</button>");
				$('#ModalGue').modal('show');

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(11) input').val('');
			}
		}
	});

	$.ajax({
		url: "https://apotikmahira.com/index.php/barang/cek-stok2_hamzah",
		type: "POST",
		cache: false,
		data: "kode_barang="+encodeURI(KodeBarang)+"&stok_hamzah="+JumlahBesar*Nilai,
		dataType:'json',
		success: function(data){
			if(data.status == 1)
			{
				if(Nilai > 0)
				{
					var JumlahBuy =  parseFloat(JumlahBesar) * parseFloat(Nilai);
				}
				else {
					var JumlahBuy = 0;
				}

				var DiscBeli = parseFloat(Hnasional) * parseFloat(Diskon) / 100
				var Pokok = parseFloat(Hnasional) - parseFloat(DiscBeli)
				var Ppnna = parseFloat(Pokok) * 11/100
				var Nasional = parseFloat(Hnasional) + parseFloat(Ppnna)
				
				var Modal = parseFloat(Pokok) + parseFloat(Ppnna);
					
				var SubTotal = parseFloat(Modal) * parseFloat(JumlahBuy);
				if(Nasional > -1){
					var JumlahBuyVal = JumlahBuy;
					JumlahBuy = JumlahBuy.toFixed(0);
					var SubTotalVal = SubTotal;
					SubTotal = SubTotal.toFixed(0);
				} else {
					SubTotal = '';
					var SubTotalVal = 0;
				}

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(28) input').val(SubTotalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(28) span').html(SubTotal);
				HitungTotalBayar();
			}
			if(data.status == 0)
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok, Saya Mengerti</button>");
				$('#ModalGue').modal('show');

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(11) input').val('');
			}
		}
	});
});

$(document).on('keydown', '#jumlah_buy', function(e){
	var charCode = e.which || e.keyCode;
	if(charCode == 9){
		var Indexnya = $(this).parent().parent().index() + 1;
		var TotalIndex = $('#TabelTransaksi tbody tr').length;
		if(Indexnya == TotalIndex){
			BarisBaru();
			return false;
		}
	}

	HitungTotalBayar();
});


$(document).on('keyup', '#DPP', function(){

	HitungPPN();
	HitungTotalBiaya();
	HitungBayar();
});




$(document).on('keyup', '#TotalBiaya', function(){

	HitungDPP();
	HitungPPN2();
	HitungBayar();
	
});






function HitungTotalBayar()
{
	
	var Total = 0;
	$('#TabelTransaksi tbody tr').each(function(){
		if($(this).find('td:nth-child(28) input').val() > 0)
		{
			var SubTotal = $(this).find('td:nth-child(28) input').val();

			Total = parseFloat(Total) + parseFloat(SubTotal);
			Total = Total.toFixed(0);
		}
		
	});

	$('#TotalBayar').html(to_rupiah(Total));
	$('#TotalBayarHidden').val(Total);
	

	
}

function HitungDPP()
{

	var Tbiaya = $('#TotalBiaya').val();
	

	
		var Dpp = parseFloat(Tbiaya);
		Dpp= Dpp.toFixed(0);
		$('#DPP').val(Dpp);
	

	$('#DPP').html(to_rupiah(Dpp));
	$('#DPP').val(Dpp);

	$('#PPN2').val('');

}

function HitungPPN2()
{
	
	var Tbiaya = $('#TotalBiaya').val();
	

	
		var Ppn = 0;
		
		$('#PPN').val(Ppn);
	

	$('#PPN').html(to_rupiah(Ppn));
	$('#PPN').val(Ppn);
	

	
}

function HitungPPN()
{
	var Dpp = $('#DPP').val();
	

	
		var Ppn = parseFloat(Dpp) * 11/100;
		Ppn = Ppn.toFixed(0);
		$('#PPN').val(Ppn);
	

	$('#PPN').html(to_rupiah(Ppn));
	$('#PPN').val(Ppn);

	$('#TotalBiaya').val('');

}

function HitungTotalBiaya()
{
	var Dpp = $('#DPP').val();
	var Ppn = $('#PPN').val();
	
		
		
		var Tbiaya = parseFloat(Dpp) + parseFloat(Ppn);
		Tbiaya = Tbiaya.toFixed(0);
		$('#TotalBiaya').val(Tbiaya);
	

	$('#TotalBiaya').html(to_rupiah(Tbiaya));
	$('#TotalBiaya').val(Tbiaya);
	
}

function HitungBayar()
{
	var Pembayaran = $('#id_pembayaran').val();
	var TotalBiaya = $('#TotalBiaya').val();
	var Bayar =0;

		if(Pembayaran > 1){
					var Bayar = 0;
					
				} else {
					var Bayar = parseFloat(TotalBiaya);
					
				}
		
		$('#Bayar').val(Bayar);
		

}

function to_rupiah(angka){
    var rev     = parseFloat(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    return 'Rp. ' + rev2.split('').reverse().join('');
}

function check_int(evt) {
	var charCode = ( evt.which ) ? evt.which : event.keyCode;
	return ( charCode >= 48 && charCode <= 57 || charCode == 8 || charCode == 46 );
}

$(document).on('keydown', 'body', function(e){
	var charCode = ( e.which ) ? e.which : event.keyCode;

	if(charCode == 117) //F6
	{
		$('#DPP').focus();
		return false;
	}
	if(charCode == 118) //F7
	{
		BarisBaru();
		return false;
	}

	if(charCode == 119) //F8
	{
		$('#TotalBiaya').focus();
		return false;
	}

	

	if(charCode == 121) //F10
	{
		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Konfirmasi');
		$('#ModalContent').html("Apakah anda yakin ingin menyimpan transaksi ini ?");
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='SimpanPembelian'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
		$('#ModalGue').modal('show');

		setTimeout(function(){ 
	   		$('button#SimpanPembelian').focus();
	    }, 500);

		return false;
	}
});

$(document).on('click', '#Simpann', function(){
	$('.modal-dialog').removeClass('modal-lg');
	$('.modal-dialog').addClass('modal-sm');
	$('#ModalHeader').html('Konfirmasi');
	$('#ModalContent').html("Apakah anda yakin ingin menyimpan transaksi ini ?");
	$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='SimpanPembelian'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
	$('#ModalGue').modal('show');

	setTimeout(function(){ 
   		$('button#SimpanPembelian').focus();
    }, 500);
});

$(document).on('click', 'button#SimpanPembelian', function(){
	SimpanPembelian();
});



function SimpanPembelian()
{
	var FormData = "nomor_nota="+encodeURI($('#nomor_nota').val());
	FormData += "&no_faktur="+encodeURI($('#no_faktur').val());
	FormData += "&tanggal="+encodeURI($('#tanggal').val());
	FormData += "&tanggal_faktur="+encodeURI($('#tanggal_faktur').val());
	FormData += "&jatuh_tempo="+encodeURI($('#jatuh_tempo').val());
	FormData += "&id_kasir="+$('#id_kasir').val();
	FormData += "&id_apotik="+$('#id_apotik').val();
	FormData += "&id_pelanggan="+$('#id_pelanggan').val();
	FormData += "&id_supplier="+$('#id_supplier').val();
	FormData += "&id_pembayaran="+$('#id_pembayaran').val();
	FormData += "&status="+$('#Status').val();
	FormData += "&bayar="+$('#Bayar').val();
	FormData += "&" + $('#TabelTransaksi tbody input').serialize();
	FormData += "&grand_total="+$('#TotalBayarHidden').val();
	FormData += "&dpp="+$('#DPP').val();
	FormData += "&ppn="+$('#PPN').val();
	FormData += "&total_biaya="+$('#TotalBiaya').val();
	FormData += "&catatan="+encodeURI($('#catatan').val());
	

	$.ajax({
		url: "https://apotikmahira.com/index.php/pembelian_depo2/transaksi",
		type: "POST",
		cache: false,
		data: FormData,
		dataType:'json',
		success: function(data){
			if(data.status == 1)
			{
				alert(data.pesan);
				window.location.href="https://apotikmahira.com/index.php/pembelian_depo2/transaksi";
			}
			else 
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
				$('#ModalGue').modal('show');
			}	
		}
	});
}

$(document).on('click', '#TambahSupplier', function(e){
	e.preventDefault();

	$('.modal-dialog').removeClass('modal-sm');
	$('.modal-dialog').removeClass('modal-lg');
	$('#ModalHeader').html('Tambah Supplier');
	$('#ModalContent').load($(this).attr('href'));
	$('#ModalGue').modal('show');
});
$(document).on('click', '#TambahPelanggan', function(e){
	e.preventDefault();

	$('.modal-dialog').removeClass('modal-sm');
	$('.modal-dialog').removeClass('modal-lg');
	$('#ModalHeader').html('Tambah Pelanggan');
	$('#ModalContent').load($(this).attr('href'));
	$('#ModalGue').modal('show');
});