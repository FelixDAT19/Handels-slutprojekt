import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import LoadCompetitions from "/Components/LoadCompetitions";
// component imports

import prisma from "/api/client";
//prisma connection import



function competitions({ sponsors, competitions  }) {
  //competition page

  return (
    <div className="viewport">
      <MainMenu /* burger menu */ />

      <hr />

      <h1>Tävlingar</h1>

      <div className="textbox">Handelsmässans egna tävling</div>

      <iframe
        src="https://docs.google.com/forms/d/e/1FAIpQLScDyejaHJdpMhmQXIMY-o_LAukSPwNwp7DKPe1Wu2Wx_dy7UA/viewform?embedded=true"
        className="iframecss"
      /> {/* local competition */}

      <br/>

      <LoadCompetitions competitions={competitions} /* sends all the competitions to the loadCompetitions component *//>

      <hr />

      <FooterMenu sponsors={sponsors}  /* sends all the sponsors to the sponsor component *//>
    </div>
  );
}

export async function getStaticProps() { //query for competition data and sponsor data
  const dataSponsor = await prisma.sponsors.findMany();
  const sponsors = [...JSON.parse(JSON.stringify(dataSponsor))];

  const dataCompetitions = await prisma.competitions.findMany({include: {company: true,}})
  const competitions = [...JSON.parse(JSON.stringify(dataCompetitions))];
  
  return {
    props: {
      sponsors,
      competitions,
    },
  }; // returns competition data and sponsor data
}
export default competitions;
