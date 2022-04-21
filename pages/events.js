import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import prisma from "/api/client";

function events({ sponsors }) {
  //event page with pdf iframe
  return (
    <div className="viewport">
      <MainMenu />

      <h1>Program</h1>

      <br />

      <iframe src="/files/programblad.pdf" className="iframecss"/>

      <br />

      <FooterMenu sponsors={sponsors} />
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
  };
}
export default events;
