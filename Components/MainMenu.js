import Link from "next/link";
import { useEffect } from "react";



function MainMenu() {
  
 

    if (process.browser) {
    const nav = document.querySelector('#nav');
    const menu = document.querySelector('#menu');
    const menuToggle = document.querySelector('.nav__toggle');
    let isMenuOpen = false;
  
  
    // TOGGLE MENU ACTIVE STATE
    menuToggle.addEventListener('click', e => {
      e.preventDefault();
      isMenuOpen = !isMenuOpen;
      
      // toggle a11y attributes and active class
      menuToggle.setAttribute('aria-expanded', String(isMenuOpen));
      menu.hidden = !isMenuOpen;
      nav.classList.toggle('nav--open');
    });
  
  
    // TRAP TAB INSIDE NAV WHEN OPEN
    nav.addEventListener('keydown', e => {
      // abort if menu isn't open or modifier keys are pressed
      if (!isMenuOpen || e.ctrlKey || e.metaKey || e.altKey) {
        return;
      }
      
      // listen for tab press and move focus
      // if we're on either end of the navigation
      const menuLinks = menu.querySelectorAll('.nav__link');
      if (e.keyCode === 9) {
        if (e.shiftKey) {
          if (document.activeElement === menuLinks[0]) {
            menuToggle.focus();
            e.preventDefault();
          }
        } else if (document.activeElement === menuToggle) {
          menuLinks[0].focus();
          e.preventDefault();
        }
      }
    });
  }
  

  const linksMenu = [ //json data with information on where links are supposed to go
  {
      link: "/",
      name: "Hem",
  },
  {
      link: "/offers",
      name: "Erbjudanden",
      
    },
    {
      link: "/food",
      name: "Mat på plats",
      
    },
    {
      link: "/competitions",
      name: "Tävlingar",
      
    },
    {
      link: "/events",
      name: "Program",
      
    },
  ];

  return (

    
      <header className="header" role="banner">
    
      <nav id="nav" className="nav" role="navigation">
      
     
      <ul className="nav__menu" id="menu" tabindex="-1" aria-label="main navigation" hidden>
        {linksMenu.map(
            (
              {link, name},
              o // maps out main menu from json data
            ) => (
                <li key={o} className="nav__item">
                  <a href={link} className="nav__link">
                    {name}
                  </a>
                </li>
            )
          )}
      </ul>
      
   
      <a href="#nav" className="nav__toggle" role="button" aria-expanded="false" aria-controls="menu">
        <svg className="menuicon" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50">
          <title>Toggle Menu</title>
          <g>
            <line className="menuicon__bar" x1="13" y1="16.5" x2="37" y2="16.5"/>
            <line className="menuicon__bar" x1="13" y1="24.5" x2="37" y2="24.5"/>
            <line className="menuicon__bar" x1="13" y1="24.5" x2="37" y2="24.5"/>
            <line className="menuicon__bar" x1="13" y1="32.5" x2="37" y2="32.5"/>
            <circle className="menuicon__circle" r="23" cx="25" cy="25" />
          </g>
        </svg>
      </a>
      
     
      <div className="splash"></div>
      
    </nav>
    
  </header>

  );
}
export default MainMenu;


/*

    <div className="mainMenu">
      <Link href="/">
        <img src="https://cdn.discordapp.com/attachments/950309989157863434/958240009310334996/handek-removebg-preview.png" className='logo'/>
      </Link>
      <br />
      <div className="a-header">
        <input
          type="checkbox"
          name="main-nav"
          id="main-nav"
          className="burger-check"
        />

        <label htmlFor="main-nav" className="burger menu">
          <span></span>
        </label>
        <ul>
          {linksMenu.map(
            (
              {link, name},
              o // maps out main menu from json data
            ) => (
                <li key={o}>
                  <a href={link}>
                    {name}
                  </a>
                </li>
            )
          )}
        </ul>
      </div>

*/
