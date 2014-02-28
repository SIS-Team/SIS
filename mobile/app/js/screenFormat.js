function checkScreen(){
	if(screen.width > screen.height)
	{
		menuVertical.style.display='none';
		menuHorizontal.style.display='block';
	}
	else
	{
		menuVertical.style.display='block';
		menuHorizontal.style.display='none';
	}
}