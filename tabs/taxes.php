<div style="padding: 5px 0 5px 20px;">
<input type="button" id="add-taxes" onclick="addTaxes();" class="btn btn-primary btn-sm" value="Add New">
<input type="button" id="edit-taxes" onclick="editTaxes();" class="btn btn-primary btn-sm" value="Edit">
<input type="button" id="delete-taxes" onclick="delTaxes();" class="btn btn-primary btn-sm" value="Delete">
<span style="margin-left: 50px;">
<label for="ftdesc">Search:&nbsp;</label><input type="text" style="width: 250px; display: inline !important;" class="form-control" id="fltdesc" placeholder="Enter description"><input type="button" style="margin-left: 4px; margin-bottom: 3px;" id="search-button" type="submit" class="btn btn-default" value="Go!" onclick="filterTaxes();">
</span>
</div>
<div id="in-taxes"></div>