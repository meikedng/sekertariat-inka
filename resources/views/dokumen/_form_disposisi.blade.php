
<div class= "form-group{{ $errors->has('tgl_disposisi') ? 'has-error': '' }} ">
    {!! Form::label('tgl_disposisi', 'Tanggal Disposisi', ['class'=>'col-md-4 control-label']) !!}
    <div class = "col-md-5">
        {{ Form::text('tgl_disposisi','', array ('id' => 'datepicker')) }}
        {!! $errors->first('tgl_disposisi', '<p class= "help-block">:message</p>') !!}        
    </div>
</div>

<div class= "form-group{{ $errors->has('disposisi_kepada') ? 'has-error': '' }} ">
        {!! Form::label('disposisi_kepada', 'Kepada', ['class'=>'col-md-4 control-label']) !!}
        <div class = "col-md-5">
            {!! Form::text('disposisi_kepada', null, 
                [
                    'class'=>'form-control',
                    'placeholder'=>'Isi Keterangan'
                ]) !!}
            {!! $errors->first('disposisi_kepada', '<p class= "help-block">:message</p>') !!}
            
        </div>
</div>



<div class= "form-group{{ $errors->has('keterangan') ? 'has-error': '' }} ">
        {!! Form::label('keterangan', 'Keterangan', ['class'=>'col-md-4 control-label']) !!}
        <div class = "col-md-5">
            {!! Form::textarea('keterangan', null, 
                [
                    'class'=>'form-control',
                    'placeholder'=>'Isi Keterangan'
                ]) !!}
            {!! $errors->first('keterangan', '<p class= "help-block">:message</p>') !!}
        </div>
</div>

<div class= "form-group{{ $errors->has('penerima') ? 'has-error': '' }} ">
        {!! Form::label('penerima', 'Penerima', ['class'=>'col-md-4 control-label']) !!}
        <div class = "col-md-5">
            {!! Form::text('penerima', null, 
                [
                    'class'=>'form-control',
                    'placeholder'=>'Isi Penerima'
                ]) !!}
            {!! $errors->first('penerima', '<p class= "help-block">:message</p>') !!}
            
        </div>
</div>

<div class = "form-group">
    <div class= "col-md-4 col-md-offset-4">
        {!! Form::submit ('Simpan',['class'=>'btn btn-primary']) !!} 
    </div>
</div>

