<div class="box">
  <div class="box-header">
    <h3 class="box-title">Data Table With Full Features</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
      <tr>
        <th>Rendering engine</th>
        <th>Browser</th>
        <th>Platform(s)</th>
        <th>Engine version</th>
        <th>CSS grade</th>
      </tr>
      </thead>
      <tbody>
      <?php
        $data = array('render_engine' => 'Trident',
                      'browser' => 'Internet Explorer 4.0',
                      'platform' => 'Win 95+',
                      'engine_version' => '4',
                      'css_grade' => 'X');
          for ($i=1; $i < 100; $i++) : ?>
      <tr>
        <td><?php echo $data['render_engine']; ?></td>
        <td><?php echo $data['browser']; ?></td>
        <td><?php echo $data['platform']; ?></td>
        <td><?php echo $data['engine_version']; ?></td>
        <td><?php echo $data['css_grade']; ?></td>
      </tr>
      <?php endfor; ?>
      </tbody>
      <tfoot>
      <tr>
        <th>Rendering engine</th>
        <th>Browser</th>
        <th>Platform(s)</th>
        <th>Engine version</th>
        <th>CSS grade</th>
      </tr>
      </tfoot>
    </table>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
