@extends('emails.layouts')
@section('css')
    <style type="text/css"> * {margin:0; padding:0; text-indent:0; }
        .s1 { color: #3B4757; font-family:"Lucida Sans Unicode", sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 13.5pt; }
        .s2 { color: #3A3E44; font-family:"Lucida Sans Unicode", sans-serif; font-style: normal; text-decoration: none; font-size: 11.5pt; }
        .s3 { color: #3A3E44; font-family:"Lucida Sans Unicode", sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 11.5pt; }
        .s4 { color: #3A3E44; font-family:"Segoe UI Emoji", sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 12pt; }
        .s5 { color: #161C2D; font-family:"Lucida Sans Unicode", sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 11.5pt; }
        .s6 { color: #161C2D; font-family:"Lucida Sans Unicode", sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 11.5pt; }
        .s7 { color: #161C2D; font-family:"Lucida Sans Unicode", sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 13.5pt; }
        .s8 { color: #4471C4; font-family:"Lucida Sans Unicode", sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 13.5pt; }
        .s9 { color: #3A3E44; font-family:"Segoe UI Emoji", sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 11.5pt; }
        .s11 { color: #00F; font-family:"Lucida Sans Unicode", sans-serif; font-style: normal; font-weight: normal; text-decoration: underline; font-size: 12pt; }
        .s12 { color: black; font-family:"Lucida Sans Unicode", sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 11pt; }
        .s13 { color: #3A3E44; font-family:"Segoe UI Emoji", sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 11.5pt; }
        .s14 { color: black; font-family:"Times New Roman", serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 10pt; }
        table, tbody {vertical-align: top; overflow: visible; }
    </style>
@endsection
@section('content')
    <table style="border-collapse:collapse;margin: auto !important;" cellspacing="0">
        <tr style="height:32pt">
            <td colspan="2">
                <p class="s1" style="padding-left: 22pt;text-indent: 0pt;line-height: 17pt;text-align: left;">Hola {{ $informacion->name }} {{ $informacion->apellido }}</p>
            </td>
        </tr>
        <tr style="height:95pt">
            <td>
                <p style="text-indent: 0pt;text-align: left;">
                    <br/>
                </p>
                <p class="s2" style="padding-left: 26pt;text-indent: 0pt;text-align: left;">Recibimos el pago de arriendo de la propiedad ubicada en {{ $informacion->direccion }} {{ $informacion->numero }} 
                @if($informacion->block) departamento {{ $informacion->block}} @endif, comuna de {{ $informacion->nombreComuna }}, Región {{ $informacion->nombreRegion}} 
                y está todo <span class="s4">👌</span>
                </p>
                <p style="text-indent: 0pt;text-align: left;">
                    <br/>
                </p>
                <p class="s3" style="padding-left: 26pt;text-indent: 0pt;text-align: left;">Aquí podrás encontrar el detalle:</p>
            </td>
            <td style="width:47pt">
                <p style="text-indent: 0pt;text-align: left;">
                    <br/>
                </p>
            </td>
        </tr>
    </table>
    <table style="border-collapse:collapse;margin: auto !important; width: 100%" cellspacing="0">
        <tr style="height:25pt">
            <td>
                <p class="s5" style="padding-top: 7pt;padding-left: 26pt;text-indent: 0pt;line-height: 17pt;text-align: left;">Valor arriendo</p>
            </td>
            <td>
                <p class="s6" style="padding-top: 7pt;padding-left: 4pt;text-indent: 0pt;line-height: 17pt;text-align: left;">$ {{ number_format($informacion->arriendoMensual, 0, '', '.')}}</p>
            </td>
        </tr>
        <tr style="height:18pt">
            <td bgcolor="#EEF1F3">
                <p class="s5" style="padding-left: 26pt;text-indent: 0pt;line-height: 17pt;text-align: left;">Garantia</p>
            </td>
            <td bgcolor="#EEF1F3">
                <p class="s6" style="padding-left: 4pt;text-indent: 0pt;line-height: 17pt;text-align: left;">$ {{ number_format($informacion->garantia, 0, '', '.')}}</p>
            </td>
        </tr>
        <tr style="height:18pt">
            <td bgcolor="#EEF1F3">
                <p class="s5" style="padding-left: 26pt;text-indent: 0pt;line-height: 17pt;text-align: left;">Reajuste</p>
            </td>
            <td bgcolor="#EEF1F3">
                <p class="s6" style="padding-left: 4pt;text-indent: 0pt;line-height: 17pt;text-align: left;">$</p>
            </td>
        </tr>
        <tr style="height:18pt">
            <td>
                <p class="s5" style="padding-left: 26pt;text-indent: 0pt;line-height: 17pt;text-align: left;">Multa</p>
            </td>
            <td>
                <p class="s6" style="padding-left: 4pt;text-indent: 0pt;line-height: 17pt;text-align: left;">$</p>
            </td>
        </tr>
        <tr style="height:18pt">
            <td bgcolor="#EEF1F3">
                <p class="s5" style="padding-left: 26pt;text-indent: 0pt;line-height: 17pt;text-align: left;">Adicionales</p>
            </td>
            <td bgcolor="#EEF1F3">
                <p class="s6" style="padding-left: 4pt;text-indent: 0pt;line-height: 17pt;text-align: left;">$ {{ number_format($cargos, 0, '', '.')}}</p>
            </td>
        </tr>
        <tr style="height:23pt">
            <td >
                <p class="s5" style="padding-left: 26pt;text-indent: 0pt;line-height: 18pt;text-align: left;">Descuentos</p>
            </td>
            <td >
                <p class="s6" style="padding-left: 4pt;text-indent: 0pt;line-height: 18pt;text-align: left;">$ {{ number_format($descuentos, 0, '', '.')}}</p>
            </td>
        </tr>
        <tr style="height:33pt">
            <td >
                <p class="s7" style="padding-top: 6pt;padding-left: 26pt;text-indent: 0pt;text-align: left;">Total</p>
            </td>
            <td >
                <p class="s8" style="padding-top: 6pt;padding-left: 4pt;text-indent: 0pt;text-align: left;">$ {{ number_format($informacion->subtotal, 0, '', '.')}}</p>
            </td>
        </tr>
        <tr style="height:77pt">
            <td colspan="2">
                <p class="s3" style="padding-top: 5pt;padding-left: 7pt;text-indent: 0pt;text-align: left;">
                    <span class="s9">☝</span>Recuerda que ya recibimos el pago, por lo que <b>no debes enviarnos el comprobante </b>correspondiente.
                </p>    
            </td>
        </tr>
        <tr style="height:123pt" style="margin: auto !important">
            <td colspan="2">
                <p style="text-indent: 0pt;text-align: left;">
                    <br/>
                </p>
                <p style="padding-top: 10pt; text-align: center;">
                    <a href="mailto:administracion@propitech.cl" style=" color: #3A3E44; font-family:&quot;Lucida Sans Unicode&quot;, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 12pt;" target="_blank">
                        ¡Siempre estamos para ayudarte! 
                    </a>
                    <br>
                    <a href="mailto:administracion@propitech.cl" class="s11" target="_blank">
                        administracion@propitech.cl
                    </a>
                </p>
                <p style="text-indent: 0pt;text-align: left;">
                    <br/>
                </p>
                <p style="text-align: center;">
                    <span>
                        <table border="0" cellspacing="0" cellpadding="0" style="margin: auto !important;">
                            <tr>
                                <td>
                                    <img width="118" height="34" src="https://propitech.cl/front/011.png"/>
                                </td>
                            </tr>
                        </table>
                    </span>
                </p>
            </td>
        </tr>
    </table>
    <table border="0" cellspacing="0" cellpadding="0" style="margin: auto !important">
        <tbody>
            <tr>
                <td>
                    <img style="margin-left: 4px;margin-right: 4px;" width="31" height="31" src="data:image/png;base64,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">
                </td>
                <td>
                    <span style="margin-left: 4px;margin-right: 4px;" ><a href="https://www.linkedin.com/search/results/all/?fetchDeterministicClustersOnly=true&amp;heroEntityKey=urn%3Ali%3Aorganization%3A98935963&amp;keywords=propitech&amp;origin=RICH_QUERY_SUGGESTION&amp;position=0&amp;searchId=04c28821-82b6-4ac7-85c5-1fb36df538bf&amp;sid=ppF&amp;spellCorrectionEnabled=false"><img width="31" height="31" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB8AAAAfCAYAAAAfrhY5AAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFa0lEQVRIia1XTWhUVxT+zpuYefc+U23H4F9sS8U0xXZXC0I3pssSECegMHsLLpKUtguRmcVIu2m7yLJCrQuhmypUIq6yioE2RrB0E0ahVkoQHZNYnamvOufr4r375r03k4XQYe57992f851z7rnnfldIgiREBO5HEgAgIkm9/mV99PZK49ilSz99CJFREewCxAJsk7gPslEuT14/MDZ6uXam1nDz8z+HRTL62Kw0m02pVCoTvl+8YayvJvBpA0MbGJr43a37NIFRY331/eKNSqUy0Ww2hSRUNZGZricf6beqolqtjpSGSwvG+upArHVvX21g1AEb21UqUcj6WhouLVSr1ZGXAp+anjpirL9u08BBf+BYIbWByXjGBr7Giq1PTU8dcUa50uN2VcX0zNQpY/0wY2m2qLU+bQxkrKEJ/PRYzc8z1g+nZ6ZO5Q3NAMcWh9Ya7Wt1JDjXnnd5dl4cG2qsHzoPJG53lWq1OmKsv54Opq1Dge4d2cPdu3dlFchYlV+WjOWalmesv16tVkcy4M1mU0rDpQWTA75y5WeG4TO2Wk858+lMvyWgSSlj+vTn20vDpQW3C6CqqFQqE/mo3juyh2H4jKSSVN69+weHXtnaY3kWpDfq88tmrK+VSmVCVSGqCmvNDa/gvZ9OBNu3bcedO3dgrQUArKys4NAHh6CqBJDKHgQpECEBkagBEo1I2oDULO3ocrv9z6GCDMjo4uLiVxARiYYAAMJ/Qzx+/Le8e/AgVldXcfKTk1hdXXWAksiHQBBhEBCJNYmgImCClHS6E+zusPPjwO2VxjERSKIlkSh77tx3OH/++2RvOgMAoQDiTEwhuTydyavRWLiRhEBurzSOie8PznmFwscZxxDwCh4mJiZQLBYBgI8ePZL5+XkMDg7i6NGjieDl5WWura3LiRMnePjwYRncsoVLS0u4ePGiPGw+ACiRVBIUUCCCaGtfhW+KjVxEqg18vlZ6lQ8fPlDVjpLKX5d+URsYfePN19npvCDZoarq2bN13rv3p6pG36RStaNPnjzh2DtvJwFskqTk0wSGvik2vOh0AsQdX5GXui7rrlXGlaRQBHL69Gns2zciIgIRCEmKQILA4sIPFygiQGRxd2FJiGDXQHQsIjn/GDnKgbmYZfo7Gh7VPc/DrVu/Ye7qHPa/tR/Hjx+HiAcRYGxsTKy1aLVaAoARQhzZhB0A2AZkKBUcAHMBI9nvdHysra1h/KNxhmEoALBz504ZHx8HAFhrUSwW0Wq13JTEQIBtj8T9nOAeqNjyNHDSdu3aNYTPwqRzfn6erm9gYACFQiE7mYx2CnHfA9nISM2bSDBnecb96xvrTl2C0a5w4124xM84EUSrDrLhlcuT1yOM7gJn3CBMA7vORKHOiw7gstrmNnTVZpSiyuXJ696BsdHLZGpmpFcKTFL1nrVP3BP7oyfBxIp167H8A2Ojl73amVqDyptugES2prZdRu9+ddDl9F6tgHQMEQJQqLxZO1NreABQLk/WmfK3bGZhTmpOlT5zsk2MthjL5ck6AHgigtnZ2TkbBIuJTOatoHu4InmZ0b9nU3TnxU8bBIuzs7NzEmckAECtVhv55tuvf4fINmd5qVSC53kAgOfPn2NjYwMigh07diSC2+02nrZayZHm+0aGhpK0wZg4RGFGbHz+2Rfv1ev1vwCgH2sNE25mHQ3yY6K4GWPxk/aE39seEpHhcKqKHtrs2GuGHtmYLqUFWqMmy2qSfpOal2evPeB5+pzw9n5UyGbpUtcjfupUTJHHFG/PY6Ff46Y3lhwbTV8OuqDJ0Zm5sfS7nLzUXS0DbFMltfb97mr9iqp2oz19U83Xgf/nlpqX+x8ZlbhS+wsaJQAAAABJRU5ErkJgggAA"></a></span>
                </td>
                <td>
                    <span style="margin-left: 4px;margin-right: 4px;" ><a href="https://api.whatsapp.com/send/?phone=56956790356&amp;text&amp;type=phone_number&amp;app_absent=0&amp;utm_source=sendinblue&amp;utm_campaign=CHI%20-%20TRA-%20%20TENANT%20COBRO%20MENSUALIDAD&amp;utm_medium=email"><img width="31" height="31" src="data:image/png;base64,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"></a></span>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
