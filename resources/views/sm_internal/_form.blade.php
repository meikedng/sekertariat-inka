
<div class= "form-group{{ $errors->has('tgl_masuk') ? 'has-error': '' }} ">
    {!! Form::label('tgl_masuk', 'Tanggal Masuk Dokumen ', ['class'=>'col-md-4 control-label']) !!}
    <div class = "col-md-5">
        {{ Form::text('tgl_masuk','', array ('id' => 'datepicker')) }}
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

{{--  <div class= "form-group{{ $errors->has('no_surat') ? 'has-error': '' }} ">
        {!! Form::label('no_surat', 'Nomor Surat', ['class'=>'col-md-4 control-label']) !!}
        <div class = "col-md-5">
            {!! Form::text('no_surat', null, 
                [
                    'class'=>'form-control',
                    'placeholder'=>'Isi Nomor Surat'
                ]) !!}
            {!! $errors->first('no_surat', '<p class= "help-block">:message</p>') !!}
        </div>
</div>  --}}

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

<div class= "form-group{{ $errors->has('dokumen') ? 'has-error': '' }} ">
        {!! Form::label('dokumen', 'Dokumen', ['class'=>'col-md-4 control-label']) !!}
        <div class = "col-md-5">
            {!! Form::text('dokumen', null, 
                [
                    'class'=>'form-control',
                    'placeholder'=>'Dokumen'
                ]) !!}
            {!! $errors->first('dokumen', '<p class= "help-block">:message</p>') !!}
        </div>
</div>

<div class= "form-group{{ $errors->has('jenis_dokumen') ? 'has-error': '' }} ">
    {!! Form::label('jenis_dokumen', 'Jenis Dokumen', ['class'=>'col-md-4 control-label']) !!}
    <div class = "col-md-5">
        {!! Form::select ('jenis_dokumen', [ '' => '' ]+
            $list_circular->pluck('label','id')->all(),null,
            [
                'class' => 'js-selectize',
                'placeholder' => 'Pilih Jenis Dokumen'
            ]) 
        !!}        
    </div>
</div>

<div class= "form-group{{ $errors->has('first_destination') ? 'has-error': '' }} ">
    {!! Form::label('first_destination', 'Tujuan Pertama', ['class'=>'col-md-4 control-label']) !!}
    <div class = "col-md-5">
        {!! Form::select ('first_destination', [ '' => '' ]+
            App\mDireksi::where('id',$first_dest->direksi_id)->pluck('nama_direksi','id')->all(),null,
        [
            'class' => 'js-selectize',
            'placeholder' => 'Pilih Nama Direksi'
        ]) !!}  
        {!! $errors->first('first_destination', '<p class= "help-block">:message</p>') !!}
        
    </div>
</div>

<div class= "form-group{{ $errors->has('second_destination') ? 'has-error': '' }} ">
    {!! Form::label('second_destination', 'Tujuan Kedua', ['class'=>'col-md-4 control-label']) !!}
    <div class = "col-md-5">
        {!! Form::select ('second_destination', [ '' => '' ]+
            App\mDireksi::where('id','<>',$first_dest->direksi_id)
                ->pluck('nama_direksi','id')->all(),null,
        [
            'class' => 'js-selectize',
            'placeholder' => 'Pilih Nama Direksi'
        ]) !!}  
        {!! $errors->first('second_destination', '<p class= "help-block">:message</p>') !!}
        
    </div>
</div>

<div class= "form-group{{ $errors->has('third_destination') ? 'has-error': '' }} ">
    {!! Form::label('third_destination', 'Tujuan Ketiga', ['class'=>'col-md-4 control-label']) !!}
    <div class = "col-md-5">
        {!! Form::select ('third_destination', [ '' => '' ]+
            App\mDireksi::where('id','<>',$first_dest->direksi_id)
                ->pluck('nama_direksi','id')->all(),null,
        [
            'class' => 'js-selectize',
            'placeholder' => 'Pilih Nama Direksi'
        ]) !!}  
        {!! $errors->first('third_destination', '<p class= "help-block">:message</p>') !!}
        
    </div>
</div>

<div class= "form-group{{ $errors->has('fourth_destination') ? 'has-error': '' }} ">
    {!! Form::label('fourth_destination', 'Tujuan Keempat', ['class'=>'col-md-4 control-label']) !!}
    <div class = "col-md-5">
        {!! Form::select ('fourth_destination', [ '' => '' ]+
            App\mDireksi::where('id','<>',$first_dest->direksi_id)
                ->pluck('nama_direksi','id')->all(),null,
        [
            'class' => 'js-selectize',
            'placeholder' => 'Pilih Nama Direksi'
        ]) !!}  
        {!! $errors->first('fourth_destination', '<p class= "help-block">:message</p>') !!}
        
    </div>
</div>

<div class = "form-group">
    <div class= "col-md-4 col-md-offset-4">
        {!! Form::submit ('Simpan',['class'=>'btn btn-primary']) !!} 
    </div>
</div>

