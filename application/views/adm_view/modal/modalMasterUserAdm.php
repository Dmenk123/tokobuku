<!-- modal add_user -->
<div class="modal fade" id="modal_form" role="dialog" aria-labelledby="add_user" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
         </div>
         <div class="modal-body">
            <form id="form" name="formUser">
               <div class="form-row">
                  <input type="hidden" name="userId">
                  <div class="form-group col-md-12">
                     <label for="lblFname" class="lblFnameErr">Nama Lengkap</label>
                     <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="lblEmail" class="lblEmailErr">Email</label>
                     <input type="email" class="form-control" name="email" placeholder="Email">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="lblProv" class="lblProvErr">Provinsi</label>
                     <select class="form-control" id="user_prov" name="userProvinsi" style="width: 100%;"></select>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="lblKota" class="lblKotaErr">Kota</label>
                     <select class="form-control" id="user_kota" name="userKota" style="width: 100%;"></select>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="lblKec" class="lblKecErr">Kecamatan</label>
                     <select class="form-control" id="user_kec" name="userKecamatan" style="width: 100%;"></select>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="lblKel" class="lblKelErr">Kelurahan</label>
                     <select class="form-control" id="user_kel" name="userKelurahan" style="width: 100%;"></select>
                  </div>
               </div> 
               <div class="form-group col-md-12">
                  <label for="lblAlmt" class="lblAlmtErr">Alamat</label>
                  <input type="text" class="form-control" name="userAlamat" placeholder="Alamat Rumah">
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="lblTelp" class="lblTelpErr">Nomor Telp</label>
                     <input type="text" class="form-control numberinput" name="userTelp" placeholder="contoh : 08121212112">
                  </div>
                  <div class="form-group col-md-6">
                     <label for="lblKdps" class="lblKdposErr">Kode Pos</label>
                     <input type="text" class="form-control numberinput" name="userKdpos" placeholder="contoh : 61789">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="lblLvlUser" class="lblLvlUserErr">Level User</label>
                     <select class="form-control" id="user_level" name="userLevel" style="width: 100%;" required>
                        <option value="">-- Pilih Level User --</option>
                        <option value="1">Administrator</option>
                        <option value="2">Customer</option>
                        <option value="3">Admin</option>
                        <option value="4">Vendor</option>
                     </select>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="lblTgllhr" class="lblTgllhrErr">Tgl Lahir</label>
                     <input type="text" class="form-control" name="userTgllhr">
                  </div>
                  <div class="form-group col-md-6">
                     <label for="lblFotoUser" class="lblFotoUserErr">Foto User</label>
                     <input type="file" id="user_foto" name="userFoto" accept=".png, .jpg, .jpeg">
                     <p class="help-block"><strong>Catatan : Apabila tidak ingin merubah foto, Mohon lewati pilihan ini</strong></p>
                  </div>
               </div> 
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
         </div>
      </div>
   </div>
<div>