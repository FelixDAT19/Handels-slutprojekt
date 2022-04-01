import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import { PrismaClient } from "@prisma/client";
const prisma = new PrismaClient();

function about({ sponsors }) {
  //omsidan
  return (
    <>
      <MainMenu />

      <h1>Om</h1>
      <br />
      <p>öppettider</p>
      <p>12-19</p>
      <p>10-18</p>

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
export default about;
