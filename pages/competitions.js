import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import prisma from "/api/client";
import LoadCompetitions from "/Components/LoadCompetitions";


function competitions({ sponsors, competitions  }) {
  //Tävlingar

  return (
    <>
      <MainMenu />

      <hr />

      <h1>Tävlingar</h1>

      <h2>Handelsmässans egna tävling</h2>

      <iframe
        src="https://docs.google.com/forms/d/e/1FAIpQLScDyejaHJdpMhmQXIMY-o_LAukSPwNwp7DKPe1Wu2Wx_dy7UA/viewform?embedded=true"
        className="iframecss"
      />
      <br/>

      <h2>företags tävlingar</h2>

      <LoadCompetitions competitions={competitions}/>

      <hr />

      <FooterMenu sponsors={sponsors} />
    </>
  );
}

export async function getStaticProps() {
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
