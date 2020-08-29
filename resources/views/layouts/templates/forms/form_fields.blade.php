<div class="row">
<?php foreach( $formFields as $form_name => $attr ): ?>
    
    <?php
        $value          = ( ( isset( $data->$form_name ) && ( $data->$form_name != NULL) )   ? ( isset( $data->$form_name ) ? $data->$form_name : old( $form_name ) ) : old( $form_name )  );
        $value          = ( isset( $attr['value'] )  ) ? $attr['value'] : $value;
        $type           = ( isset( $attr['type'] )  ) ? $attr['type'] : 'text';
        $name           = $form_name;
        $id             = ( isset( $attr['id'] ) ) ? $attr['id'] : $name ;
        $label          = ( isset( $attr['label'] )  ) ? $attr['label'] : $name;
        $placeholder    = ( isset( $attr['placeholder'] )  ) ? $attr['placeholder'] : $label;
        $readonly       = ( isset( $attr['readonly'] )  ) ? "readonly" : '';

        $labeled       = ( isset( $attr['labeled'] )  ) ? $attr['labeled'] : true ;

        $labelHtml      = ( $labeled  ) ? '<label for="'.$name.'">'.$label.'</label>' : '';

        $weight       = ( isset( $attr['weight'] )  ) ? $attr['weight'] : 'col-md-12';

        if( $attr['type'] == 'hidden' )
        {
            // echo Form::hidden( $form_name, $value );
            ?>
            <input 
                id="{{$id}}" 
                type="hidden" 
                class="form-control @error('{{$name}}') is-invalid @enderror" 
                name="{{$name}}" 
                value="{{ $value}}" 
                <?= $readonly ?>
                autocomplete="{{$name}}" 
                placeholder="{{$placeholder}}" >
            <?php
            continue;
        }
    ?>
        <div class="<?= $weight?> {{ $attr['type'] == 'time' ? 'bootstrap-timepicker' : '' }}">
            <?= $labelHtml ?>
        <?php

            switch(  $attr['type'] )
            {
                case 'time':
                    ?>
                    <input 
                        id="{{$id}}" 
                        type="text" 
                        class="form-control timepicker @error('{{$name}}') is-invalid @enderror" 
                        name="{{$name}}" 
                        value="{{$value}}" 
                        required 
                        <?= $readonly ?>
                        autocomplete="{{$name}}" 
                        placeholder="{{$placeholder}}" >
                    <?php
                    break;
                case 'date':
                    ?>
                    
                    <input 
                        id="{{$id}}" 
                        type="{{$type}}" 
                        class="form-control datepicker @error('{{$name}}') is-invalid @enderror" 
                        name="{{$name}}" 
                        value="{{$value}}" 
                         
                        <?= $readonly ?>
                        autocomplete="{{$name}}" 
                        placeholder="{{$placeholder}}" >
                    <?php
                    break;
                case 'password':
                case 'email':
                case 'text':
                case 'number':
                    ?>
                    <input 
                        id="{{$id}}" 
                        type="{{$type}}" 
                        class="form-control @error('{{$name}}') is-invalid @enderror" 
                        name="{{$name}}" 
                        value="{{$value}}" 
                         
                        <?= $readonly ?>
                        autocomplete="{{$name}}" 
                        placeholder="{{$placeholder}}" >
                    <?php
                    break;
                case 'textarea':
                    ?>
                    <textarea 
                        id="{{$id}}" 
                        type="{{$type}}" 
                        class="form-control @error('{{$name}}') is-invalid @enderror" 
                        name="{{$name}}" 
                        value="{{$value}}" 
                         rows='5'
                        <?= $readonly ?>
                        autocomplete="{{$name}}" 
                        placeholder="{{$placeholder}}" ><?= $value?></textarea>
                    <?php
                    break;
                case 'multiple_file':
                    ?>
                    <input 
                        id="{{$id}}" 
                        type="file" 
                        class="form-control @error('{{$name}}') is-invalid @enderror" 
                        name="{{$name}}" 
                        multiple
                        placeholder="{{$placeholder}}" >
                    <?php
                    break;
                case 'file':
                    ?>
                    <input 
                        id="{{$id}}" 
                        type="{{$type}}" 
                        class="form-control @error('{{$name}}') is-invalid @enderror" 
                        name="{{$name}}" 
                        placeholder="{{$placeholder}}" >
                    <?php
                    break;
                case 'select_search':
                    $options = ( isset( $attr['options'] )  ) ? $attr['options'] : [];
                    ?>
                    
                    <select 
                        id="{{$id}}" 
                        class="form-control show-tick select2 @error('{{$name}}') is-invalid @enderror" 
                        name="{{$name}}" 
                        <?= $readonly ?>
                    >
                        <?php foreach( $options as $key => $value_ ) : ?>
                            <option <?= $check = ( $value == $key ) ? 'selected' : '' ?> value="<?= $key?>"><?= $value?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php
                    break;
                case 'select':
                    $options = ( isset( $attr['options'] )  ) ? $attr['options'] : [];
                    ?>
                    
                    <select 
                        id="{{$id}}" 
                        class="form-control @error('{{$name}}') is-invalid @enderror" 
                        name="{{$name}}" 
                        <?= $readonly ?>
                    >
                        <?php foreach( $options as $key => $value_ ) : ?>
                            <option <?= $check = ( $value == $key ) ? 'selected' : '' ?> value="<?= $key?>"><?= $value_?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php
                    break;
            }
        ?>
        </div>
<?php endforeach; ?>
</div>