import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
//component import

import prisma from "/api/client";
//prisma client import

function events({ sponsors }) {
  //event page with pdf iframe
  return (
    <div className="viewport">
      <MainMenu /* burger menu */ />

      <h1>Program</h1>

      <br />

      <iframe src="/files/programblad.pdf" className="iframecss"/> {/* the programs of handelsmässan displayed as a pdf */}

      <br />

      <FooterMenu sponsors={sponsors} /* sends all the sponsors to the sponsor component *//>
    </div>
  );
}

export async function getStaticProps() { // fetches sponsors
  const dataSponsor = await prisma.sponsors.findMany();
  const sponsors = [...JSON.parse(JSON.stringify(dataSponsor))];

  return {
    props: {
      sponsors,
    },
  }; // returns sponsors
}
export default events;
