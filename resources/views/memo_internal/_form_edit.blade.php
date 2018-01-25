{{--  <div class= "form-group{{ $errors->has('nomor_urut_dokumen') ? 'has-error': '' }} ">
    {!! Form::label('nomor_urut_dokumen', 'Nomor Urut Dokumen', ['class'=>'col-md-4 control-label']) !!}
        <div class = "col-md-5">
            {!! Form::label('nomor_urut_dokumen', 'Nomor Urut Dokumen', ['class'=>'col-md-4 control-label']) !!}
            {!! $errors->first('nomor_urut_dokumen', '<p class= "help-block">:message</p>') !!}
        </div>
</div>  --}}
<div class= "form-group{{ $errors->has('lbl_nomor_dokumen') ? 'has-error': '' }} ">
    <div class="col-md-4 control-label">No. Dokumen</div>
    <div class="col-md-5"> {{ ($memo_internal->nomor_dokumen) }}</div>
</div>

<div class= "form-group{{ $errors->has('nomor_urut_dokumen') ? 'has-error': '' }} ">
    {!! Form::label('nomor_urut_dokumen', 'Nomor Urut Dokumen', ['class'=>'col-md-4 control-label']) !!}
    <div class = "col-md-5">
        {!! Form::number('nomor_urut_dokumen',$nomor_urut_dokumen, 
            [
                'class'=>'nomor_urut_dokumen',
                'placeholder'=>'Isi Nomor Urut Dokumen'
            ]) !!}
        {!! $errors->first('nomor_urut_dokumen', '<p class= "help-block">:message</p>') !!}
    </div>
</div>

<div class= "form-group{{ $errors->has('tgl_masuk') ? 'has-error': '' }} ">
    {!! Form::label('tgl_masuk', 'Tanggal Masuk Dokumen ', ['class'=>'col-md-4 control-label']) !!}
    <div class = "col-md-5">
        {{ Form::text('tgl_masuk',null, array ('id' => 'datepicker')) }}
        {!! $errors->first('tgl_masuk', '<p class= "help-block">:message</p>') !!}        
    </div>
</div>

<div class= "form-group{{ $errors->has('pengirim') ? 'has-error': '' }} ">
    {!! Form::label('pengirim', 'Unit Pengirim', ['class'=>'col-md-4 control-label']) !!}
    <div class = "col-md-5">
        {!! Form::select ('pengirim', [ '' => '' ]+
            App\mDivisi::pluck('division_name','id')->all(),null,
        [
            'class' => 'js-selectize',
            'placeholder' => 'Pilih Unit Pengirim'
        ]) !!}  
        {!! $errors->first('pengirim', '<p class= "help-block">:message</p>') !!}
    </div>
</div>

{{--  
<div class= "form-group{{ $errors->has('tgl_surat') ? 'has-error': '' }} ">
    {!! Form::label('tgl_surat', 'Tanggal Dokumen ', ['class'=>'col-md-4 control-label']) !!}
    <div class = "col-md-5">
        {{ Form::text('tgl_surat','', array ('id' => 'datepicker1')) }}
        {!! $errors->first('tgl_surat', '<p class= "help-block">:message</p>') !!}        
    </div>
</div>  --}}

<div class= "form-group{{ $errors->has('nomor_referensi') ? 'has-error': '' }} ">
        {!! Form::label('nomor_referensi', 'Nomor Memo', ['class'=>'col-md-4 control-label']) !!}
        <div class = "col-md-5">
            {!! Form::text('nomor_referensi', null, 
                [
                    'class'=>'form-control',
                    'placeholder'=>'Isi Nomor Memo'
                ]) !!}
            {!! $errors->first('nomor_referensi', '<p class= "help-block">:message</p>') !!}
        </div>
</div>

{{--  <div class= "form-group{{ $errors->has('perihal') ? 'has-error': '' }} ">
        {!! Form::label('perihal', 'Perihal', ['class'=>'col-md-4 control-label']) !!}
        <div class = "col-md-5">
            {!! Form::text('perihal', null, 
                [
                    'class'=>'form-control',
                    'placeholder'=>'Perihal'
                ]) !!}
            {!! $errors->first('perihal', '<p class= "help-block">:message</p>') !!}
            
        </div>
</div>  --}}

<div class= "form-group{{ $errors->has('perihal') ? 'has-error': '' }} ">
        {!! Form::label('perihal', 'Dokumen', ['class'=>'col-md-4 control-label']) !!}
        <div class = "col-md-5">
            {!! Form::text('perihal', null, 
                [
                    'class'=>'form-control',
                    'placeholder'=>'Dokumen'
                ]) !!}
            {!! $errors->first('perihal', '<p class= "help-block">:message</p>') !!}
        </div>
</div>

<div class= "form-group{{ $errors->has('lbl_jenis_dokumen') ? 'has-error': '' }} ">
    <div class="col-md-4 control-label">Jenis Dokumen</div>
    <div class="col-md-5"> {!! $jenis_dokumen !!}</div>
</div>

<div class= "form-group{{ $errors->has('lbl_tujuan') ? 'has-error': '' }} ">
    <div class="col-md-4 control-label">Tujuan</div>
    <div class="col-md-5"> {!! $text_tujuan !!}</div>
</div>



<div class = "form-group">
    <div class= "col-md-4 col-md-offset-4">
        {!! Form::submit ('Simpan',['class'=>'btn btn-primary']) !!} 
    </div>
</div>

