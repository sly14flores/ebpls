<div style="padding: 5px 0 5px 20px;">
<input type="button" id="add-business" onclick="addBusiness();" class="btn btn-primary btn-sm" value="Add New">
<input type="button" id="edit-business" onclick="editBusiness();" class="btn btn-primary btn-sm" value="Edit">
<input type="button" id="delete-business" onclick="delBusiness();" class="btn btn-primary btn-sm" value="Delete">
<span style="margin-left: 50px;">
<label for="fbdesc">Search:&nbsp;</label><input type="text" style="width: 250px; display: inline !important;" class="form-control" id="fbdesc" placeholder="Enter description"><input type="button" style="margin-left: 4px; margin-bottom: 3px;" id="search-button" type="submit" class="btn btn-default" value="Go!" onclick="filterBusinessActivity();">
</span>
</div>
<div id="in-business"></div>
<input id="ba_id" type="hidden" value="0">