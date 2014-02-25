
function openModalWindow(param) 
{
	if(param==1)
	{
		var div = $('GENENAME');
		var bgDiv = $('GENENAME_bg');
	}
	
	var docDim = Element.getDimensions(document.body);
	//get the size of the window and calculate where the box should be placed        
	var wDim = getBrowserWindowSize();        
	var dDim = Element.getDimensions(div);        
	div.style.top = ((wDim.height - dDim.height*2) / 2) + 'px';        
	div.style.left = ((wDim.width - dDim.width) / 2) + 'px';        
	if (docDim.height > wDim.height) 
	{            
		wDim.height = docDim.height;        
	}        
	bgDiv.style.width = wDim.width + 'px';        
	bgDiv.style.height = wDim.height + 'px';        
	Element.show(div);        
	Element.show(bgDiv);
}
function closeModalWindow(param) 
{    
	if(param==1)
	{
		Element.hide('GENENAME');    
		Element.hide('GENENAME_bg');
	}
	
}
function getBrowserWindowSize() 
{    
	var winW = 630, winH = 460;    
	if (parseInt(navigator.appVersion)>3) 
	{        
		if (navigator.appName=="Netscape") 
		{            
			winW = window.innerWidth;            
			winH = window.innerHeight;        
		}        
		if (navigator.appName.indexOf("Microsoft")!=-1) 
		{            
			winW = document.body.offsetWidth;            
			winH = document.body.offsetHeight;        
		}    
	}   var rval = {        width: winW,        height: winH    };    
	return rval;
}
