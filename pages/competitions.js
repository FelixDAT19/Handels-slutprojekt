import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import prisma from "/api/client";
import LoadCompetitions from "/Components/LoadCompetitions";


function competitions({ sponsors, competitions  }) {
  //competition page

  return (
    <>
      <MainMenu />

      <hr />

      <h1>Tävlingar</h1>

      <div className="textbox">Handelsmässans egna tävling Handelsmässans egna tävling</div>

      <iframe
        src="https://docs.google.com/forms/d/e/1FAIpQLScDyejaHJdpMhmQXIMY-o_LAukSPwNwp7DKPe1Wu2Wx_dy7UA/viewform?embedded=true"
        className="iframecss"
      />

      <h2 className="companyCompetitions">företags tävlingar</h2>

      <LoadCompetitions competitions={competitions}/>

      <hr />

      <FooterMenu sponsors={sponsors} />
    </>
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
  };
}
export default competitions;
