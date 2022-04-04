import Link from "next/link";

function MainMenu() {
  //function to load links

  const linksMenu = [
    {
      link: "/offers",
      name: "Erbjudanden",
      css: "smalbutton",
    },
    {
      link: "/menu",
      name: "Meny",
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
    {
      link: "/about",
      name: "Om",
      css: "smalbutton",
    },
  ];

  return (
    <div className="mainMenu">
      <Link href="/">
        <a
          className="headImage"
          dangerouslySetInnerHTML={{
            __html:
              "<img src=https://cdn.discordapp.com/attachments/950309989157863434/958240009310334996/handek-removebg-preview.png class='logo'>",
          }}
        ></a>
      </Link>
      <br />
      <div className="a-header">
        <input
          type="checkbox"
          name="main-nav"
          id="main-nav"
          className="burger-check"
        />

        <label for="main-nav" className="burger menu">
          <span></span>
        </label>
        <ul>
          {linksMenu.map(
            (
              { link, name, css },
              i // maps out main menu
            ) => (
                <li>
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
