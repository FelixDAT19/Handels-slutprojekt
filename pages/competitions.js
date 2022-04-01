import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import { PrismaClient } from "@prisma/client";
const prisma = new PrismaClient();

function competitions({ sponsors }) {
  //Tävlingar

  return (
    <>
      <MainMenu />

      <hr />

      <h1>Tävlingar</h1>

      <iframe
        src="https://docs.google.com/forms/d/e/1FAIpQLScDyejaHJdpMhmQXIMY-o_LAukSPwNwp7DKPe1Wu2Wx_dy7UA/viewform?embedded=true"
        id="competitionIframe"
      >
        Loading…
      </iframe>

      <hr />

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
export default competitions;
