function add_editingForm(){


    $("#submit_div").remove();
    x= `
        <div class="row">
            <div class="form-group-lg col-md-6" style="position:relative;top:-11px;">
                <label for="exampleInputFile">Delivery Deadline <span class="required"> *</span> </label>
                <div style="padding:10px;" class="input-append date form_datetime" data-date="2013-02-21T15:25:00Z">
                <input name="delivery_deadline" style="width:90%; height:40px;" size="16" type="text" value="" readonly>
                <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-remove"></i></span>
                <span style="padding:8px 5px; height:40px;" class="add-on"><i class="icon-calendar"></i></span>
                </div>
            </div>
            <div class="form-group col-md-6">
            <label for="exampleInputEmail1">Acceptance Deadline</label>
            <input type="number" step="1" min="0" class="form-control" name="acceptance_deadline" id="acceptance_deadline" placeholder="">
            </div>
        </div>
        <div class="row">          
            <div class="form-group col-md-6">
              <label for="exampleInputEmail1"> Rate</label>
              <input type="number" step="0.01" min="0" class="form-control" name="vendor_rate" id="vendor_rate" placeholder="Enter Rate">
            </div>
            <div class="form-group col-md-6">
              <label for="exampleInputEmail1">Words Count</label>
              <input type="number" step="1" min="0" class="form-control" name="words_count" id="words_count" placeholder="Enter words count">
            </div>
          </div> 
          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label>Group 1 Members </label>
                  <select class="select2" name='vendor1_translators_group1[]' id='translators_group1[]' multiple="multiple" multiple data-placeholder="Select translators" style="width: 100%;">
                   @foreach($translators as $translator)
                   <option value= "{{$translator['id']}}" >{{$translator['name']}} </option>
                   @endforeach
                  </select>
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                  <label>Group 2 Members</label>
                  <select class="select2"  name='vendor1_translators_group2[]' multiple multiple="multiple" data-placeholder="Select translators" style="width: 100%;">
                   @foreach($translators as $translator)
                   <option value= "{{$translator['id']}}" >{{$translator['name']}} </option>
                   @endforeach
                  </select>
                </div>
                </div>
            </div>  
            <div class="form-group">
                <label> Instructions</label>
                <textarea class="form-control" name="instructions" rows="3" placeholder="Enter ..."></textarea>
            </div>
            
        <div class="card-footer" id="submit_div">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>`;
                        
                        $("#createProject").append(x);
}  


