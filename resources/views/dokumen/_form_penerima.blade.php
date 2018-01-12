
<div class= "form-group{{ $errors->has('tgl_penerimaan') ? 'has-error': '' }} ">
    {!! Form::label('tgl_penerimaan', 'Tanggal Penerimaan', ['class'=>'col-md-4 control-label']) !!}
    <div class = "col-md-5">
        {{ Form::text('tgl_penerimaan','', array ('id' => 'datepicker')) }}
        {!! $errors->first('tgl_penerimaan', '<p class= "help-block">:message</p>') !!}        
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

