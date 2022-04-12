import Link from "next/link";

function MainMenu() {
  

  const linksMenu = [ //json data with information on where links are supposed to go
    {
      link: "/offers",
      name: "Erbjudanden",
      css: "smalbutton",
    },
    {
      link: "/food",
      name: "Mat på plats",
      css: "smalbutton",
    },
    {
      link: "/competitions",
      name: "Tävlingar",
      css: "smalbutton",
    },
    {
      link: "/events",
      name: "Program",
      css: "smalbutton",
    },
  ];

  return (
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
    </div>
  );
}
export default MainMenu;
