var bindBehaviors;
var ParentIdDeletedFolder;
var deleteFolderID;
var deleteFileID;
var ParentIdDeletedFile;
var deleteFolderName;
var deleteFileName;



$(document).ready(function(){	
	
	jQuery.noConflict();	
	
	bindBehaviors = function(scope) {

		jQuery("a.inline").fancybox();					
		
		jQuery(".flip",scope).mouseup(function() {
			if( jQuery(this).parent().children("ul").is(':visible')){
				jQuery(this).parent().children("ul").hide()
				jQuery(this).children('.aufzu').html("+")
			}	
			else{	
				jQuery(this).parent().children("ul").show()
				jQuery(this).children('.aufzu').html("&minus;")				
			}				
		}) 			
	

	/************************************************
	New Folder
	*************************************************/	
		jQuery('#F3',scope).submit(function() {								
			jQuery.post(ajaxAddFolderUrl,{'tx_bnbfilesharing_filesharing[parentFolder]' : jQuery('#f3parentFolder').val(), 'tx_bnbfilesharing_filesharing[name]' : jQuery('#f3foldername').val()} ,function(data){
//				alert(data)
				jQuery.post(ajaxRepaintFolderUrl,{ 'tx_bnbfilesharing_filesharing[parentFolder]' : jQuery('#f3parentFolder').val()} ,function(data){
					jQuery('#pf'+jQuery('#f3parentFolder').val()).html(data);
					bindBehaviors(jQuery('#pf'+jQuery('#f3parentFolder').val()));						
					jQuery.fancybox.close()															
				});
			});		 
		})	

		/************************************************
		Edit Folder
		*************************************************/	
		jQuery('#F4',scope).submit(function() {					

			jQuery.post(ajaxEditFolderUrl,{ 'tx_bnbfilesharing_filesharing[uid]' : jQuery('#f4FolderID').val(),'tx_bnbfilesharing_filesharing[name]' :	jQuery('#f4editfoldername').val(),'tx_bnbfilesharing_filesharing[parentFolder]' : jQuery('#f4parentFolderID').val()} ,function(data){				
//				alert(data)							
				parentFolder = jQuery('#f4parentFolderID').val();			
				jQuery.fancybox.close()
				jQuery('#pf'+parentFolder).html(data);
				bindBehaviors(jQuery('#pf'+parentFolder));						
			});		 	
		}) 			
	
		/***********************************************
		Delete Folder
		*************************************************/
		jQuery(".deletefolder",scope).mouseup(function() {		
			jQuery.post(ajaxCanDeleteFolderUrl,{ 'tx_bnbfilesharing_filesharing[uid]' : deleteFolderID ,  'tx_bnbfilesharing_filesharing[parentFolder]' : ParentIdDeletedFolder, 'tx_bnbfilesharing_filesharing[deleted]' : deleteFolderID} ,function(data){
				candelete = data;			
				if(candelete == 0){
					jQuery.fancybox( {
					'scrolling'		: 'no',
					'padding'		: 20,
					'transitionIn'	: 'none',
					'href'  :  '#error',
					'transitionOut'	: 'none'
					});
				}	
				else{
					jQuery('#deleteFolderName').html(deleteFolderName);		
					jQuery.fancybox( {
					'scrolling'		: 'no',
					'padding'		: 20,
					'transitionIn'	: 'none',
					'href'  :  '#confirmdeletefolder',
					'transitionOut'	: 'none'
					});											
				}			
			})			
		})//delete
	
		jQuery("#f5deletefolderbutton",scope).mouseup(function() {		
			jQuery.post(ajaxDeleteFolderUrl,{ 'tx_bnbfilesharing_filesharing[uid]' : deleteFolderID ,  'tx_bnbfilesharing_filesharing[parentFolder]' : ParentIdDeletedFolder,'tx_bnbfilesharing_filesharing[deleted]' : deleteFolderID } ,function(data){
				jQuery('#pf'+ParentIdDeletedFolder).html(data);							
					bindBehaviors(jQuery('#pf'+ParentIdDeletedFolder));															
				jQuery.fancybox.close()				
			})						
		})//delete			
	
		/***********************************************
		Edit filename
		*************************************************/		
		jQuery('#F1',scope).submit(function(){
		  jQuery.post(ajaxEditUrl,{ 'tx_bnbfilesharing_filesharing[uid]' : jQuery('#f1fileid').val(), 'tx_bnbfilesharing_filesharing[bezeichnung]' : jQuery('#f1bezeichnung').val()} ,function(data){	  		  	
//		  	alert(data);
				jQuery.post(ajaxRepaintFilesUrl,{ 'pid' : jQuery('#f1folderid').val()} ,function(data){	  	
	  			insertobj = jQuery('#ff'+jQuery('#f1folderid').val())
			 		insertobj.html(data);			
					jQuery.fancybox.close()							
					bindBehaviors(insertobj);						 								
				});
			});		 
		}) 						
		
		/***********************************************
		Delete File
		*************************************************/
		jQuery(".delete",scope).mouseup(function() { 	 	
		
			jQuery('#deleteFileName').html(deleteFileName);		
			jQuery.fancybox( {
			'scrolling'		: 'no',
			'padding'		: 20,
			'transitionIn'	: 'none',
			'href'  :  '#confirmdeletefile',
			'transitionOut'	: 'none'
			});								
		});				
		
		jQuery("#f6deletefilebutton",scope).mouseup(function() {				
			jQuery.post(ajaxDeleteUrl,{ 'tx_bnbfilesharing_filesharing[uid]' : deleteFileID } ,function(data){				
//				alert(data)
				jQuery.post(ajaxRepaintFilesUrl,{ 'pid' : ParentIdDeletedFile} ,function(data){
					jQuery('#ff'+ParentIdDeletedFile).html(data);
					bindBehaviors(jQuery('#ff'+ParentIdDeletedFile));
					jQuery.fancybox.close()				
				});													
			});		
		})//delete
				
		/***********************************************
		File Upload
		*************************************************/
		var options = {
		beforeSubmit:  showRequest,
		success:       showResponse,								
		url:       ajaxUploadUrl  //    your upload script
		};
		jQuery('#F2',scope).submit(function() {
		jQuery(this).ajaxSubmit(options);	
		return false;
		});
	}//scope
	bindBehaviors(this);		
})//ready

function showRequest(formData, jqForm, options) {
	jQuery("#wait").show();
	return true;
} 

function showResponse(data, statusText)  {	
//	alert(data)	
	if(data == "0"){
		jQuery.fancybox( {
		'scrolling'		: 'no',
		'padding'		: 20,
		'transitionIn'	: 'none',
		'href'  :  '#erroruploadtype',
		'transitionOut'	: 'none'
		});
	}
	else if(data == "-1"){		
		jQuery.fancybox( {
		'scrolling'		: 'no',
		'padding'		: 20,
		'transitionIn'	: 'none',
		'href'  :  '#erroruploadsize',
		'transitionOut'	: 'none'
		});
	}
	
	else{			
	jQuery.post(ajaxRepaintFilesUrl,{ pid : jQuery('#f2folderid').val()} ,function(data)		 {		
 		insertobj = jQuery('#ff'+jQuery('#f2folderid').val())				
		insertobj.html(data)  	
		bindBehaviors(insertobj)					
		jQuery.fancybox.close()		
	  });
	} 
	jQuery("#wait").hide();	
} 

/***********************************************
Fills Editmask for filenames
*************************************************/		
function editfile(folderId,fileId,fName){			
	jQuery('#f1bezeichnung').val(fName)						
	jQuery('#f1fileid').val(fileId)							
	jQuery('#f1folderid').val(folderId)							
}

/***********************************************
Fills Uploadmask
*************************************************/		
function uploadfile(folderId,fileId){	
	jQuery("#wait").hide();	
	jQuery('#f2folderid').val(folderId);					
	jQuery('#f2fileid').val(fileId);						
	jQuery('#f2bezeichnung').val("");								
	jQuery('#userfile').val("");										
}

/***********************************************
Fills EditFolder Mask
*************************************************/		
function editfolder(parentFolderId,folderID,folderName){		
		jQuery('#f4editfoldername').val(folderName);
		jQuery('#f4FolderID').val(folderID);		
		jQuery('#f4parentFolderID').val(parentFolderId);						
}
/***********************************************
Fills NewFolder Mask
*************************************************/		
function newfolder(parentFolderId){		
		jQuery('#f3parentFolder').val(parentFolderId);						
		jQuery('#f3foldername').val('');								
	
}

/***********************************************
Fills deleteFolder Globals
*************************************************/		
function deletefolder(parentFolderId,folderID,folderName){		
	ParentIdDeletedFolder = parentFolderId;
  deleteFolderID = folderID;
  deleteFolderName = folderName;  
}
/***********************************************
Fills deleteFile Globals
*************************************************/		
function deletefile(folderID,fileID,fileName){		
	deleteFileID = fileID
 	ParentIdDeletedFile = folderID;	
 	deleteFileName = fileName 	
}
/***********************************************
Download File
*************************************************/
function downloadfile(fileID){
	document.location.href = ajaxDownloadUrl+"&uid="+fileID;											
}	
