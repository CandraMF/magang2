	/* ----------------------- Author -----------------------
	Base Idea		  : Goen Goenawan
	Scripting		  : Mr. Juy, Imut (Rohimat)
	Layout & Database : Mr. Kos, Puspa RL
	Powered By		  : CV. DarmaKomunika, ICT Center Subang
	-------------------------------------------------------*/

function Grid(JmlBaris,JmlKolom,BarisKe,KolomKe,NamaForm,IdCell)
{
	this.JmlBaris = JmlBaris;
	this.JmlKolom = JmlKolom;
	this.BarisKe = BarisKe;
	this.KolomKe = KolomKe;
	this.NamaForm = NamaForm;
	this.IdCell   = IdCell;
	this.Navigasi = function(e)
	{
		if (!e) var e = window.event;
		if (e.keyCode) KeyID = e.keyCode;
		else if (e.which) KeyID = e.which;
		//alert(e)
		var Pindah = true;
		var nCol = this.KolomKe+10000;cCol = nCol+"";cCol=cCol.substr(1,4);
		var nRow = this.BarisKe+10000;cRow = nRow+"";cRow=cRow.substr(1,4);

		this.BarisKe = this.IdCell.substr(2,4)*1;
		this.KolomKe = this.IdCell.substr(6,4)*1;
		//alert(KeyID)

		if (((KeyID >=37 && KeyID <=40) || KeyID == 13 || KeyID == 13) && this.BarisKe > 0 && this.KolomKe > 0)
		{
		   switch(KeyID)
		   {
			  case 37:
			  //Panah Kiri
				if (this.KolomKe == 1)
				{
					this.KolomKe = this.JmlKolom+1;this.BarisKe--;
					if (this.BarisKe < 1)
					{
						this.BarisKe=this.JmlBaris;this.KolomKe = this.JmlKolom+1;
					}
				}
				this.KolomKe = this.KolomKe > 1 ? this.KolomKe-1 : 1;
			  break;
			  case 39:
			  case 13:
			  case 9:
			  //Panah Kanan
				if (this.KolomKe == this.JmlKolom)
				{
					this.KolomKe = 0;this.BarisKe++;
					if (this.BarisKe > this.JmlBaris)
					{
						this.BarisKe=1;this.KolomKe = 0;
					}
				}

				this.KolomKe = this.KolomKe < this.JmlKolom ? this.KolomKe+1 : this.JmlKolom;
//				alert (this.KolomKe)
			  break;

			  case 38:
			  //Panah Atas
				this.BarisKe = this.BarisKe > 1 ? this.BarisKe-1 : 1;
			  break;
			  case 40:
			  //Panah Bawah
				this.BarisKe = this.BarisKe < this.JmlBaris ? this.BarisKe+1 : this.JmlBaris;
			  break;
			  case 9:
				  Pindah = true;
			  break;
		   }
			nCol = this.KolomKe+10000;cCol = nCol+"";cCol=cCol.substr(1,4);
			nRow = this.BarisKe+10000;cRow = nRow+"";cRow=cRow.substr(1,4);
			sel = document.selection.createRange();
			Posisi = -sel.moveStart('character', -eval(this.NamaForm+"."+this.IdCell+".value.length"));
			Pindah = Posisi > 0 && KeyID==37?false:Pindah;
			Pindah = (Posisi < eval(this.NamaForm+"."+this.IdCell+".value.length")) && KeyID==39?false:Pindah;
			Pindah = KeyID==13 ?true:Pindah;
			Pindah = KeyID==9 ?true:Pindah;
			if(Pindah == true)
			{
			eval(this.NamaForm+".RC"+cRow+cCol+".focus()");
			eval(this.NamaForm+".RC"+cRow+cCol+".select()");
			}
			
		 }
	}
}