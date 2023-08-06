import {Dropdown} from "bootstrap";

const dropdownElementList = document.querySelectorAll('.dropdown-toggle')
const dropdownList = [...dropdownElementList].map(dropdownToggleEl => new Dropdown(dropdownToggleEl))

var sidebarToggler = document.querySelector('.sidebar-toggler') as HTMLLinkElement;
		
sidebarToggler.addEventListener('click', function()
{
	var mainElement = document.querySelector('.main') as HTMLDivElement
	
	if(mainElement.classList.contains('visibility-menu'))
	{
		mainElement.classList.remove('visibility-menu');
	}
	else
	{
		mainElement.classList.add('visibility-menu');
	}
});