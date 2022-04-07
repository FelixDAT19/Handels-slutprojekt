import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import prisma from "/api/client";

function events({ sponsors }) {
  return (
    <>
      <MainMenu />

      <h1>Program</h1>

      <br />

      <iframe src="/files/programblad.pdf" className="iframecss"/>

      <br />

      <FooterMenu sponsors={sponsors} />
    </>
  );
}

export async function getStaticProps() {
  const dataSponsor = await prisma.sponsors.findMany();
  const sponsors = [...JSON.parse(JSON.stringify(dataSponsor))];

  return {
    props: {
      sponsors,
    },
  };
}
export default events;
