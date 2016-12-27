<div style="padding: 5px 0 5px 20px;">
<input type="button" id="add-local-taxes" onclick="addLocalTaxes();" class="btn btn-primary btn-sm" value="Add New">
<input type="button" id="edit-local-taxes" onclick="editLocalTaxes();" class="btn btn-primary btn-sm" value="Edit">
<input type="button" id="delete-local-taxes" onclick="delLocalTaxes();" class="btn btn-primary btn-sm" value="Delete">
<span style="margin-left: 50px;">
<label for="fltdesc">Search:&nbsp;</label><input type="text" style="width: 250px; display: inline !important;" class="form-control" id="fltdesc" placeholder="Enter description"><input type="button" style="margin-left: 4px; margin-bottom: 3px;" id="search-button" type="submit" class="btn btn-default" value="Go!" onclick="filterLocalTaxes();">
</span>
</div>
<div id="in-local-taxes"></div>