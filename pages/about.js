import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import prisma from "/api/client";

function about({ sponsors }) {
  //about page
  return (
    <div className="viewport">
      <MainMenu />

      <h1>Om</h1>
      <br />
      <p>öppettider</p>
      <p>12-19</p>
      <p>10-18</p>
      <br/>

      <FooterMenu sponsors={sponsors} />
    </div>
  );
}

export async function getStaticProps() { //fetches data from database
  const dataSponsor = await prisma.sponsors.findMany();
  const sponsors = [...JSON.parse(JSON.stringify(dataSponsor))]; //turns data in to json array

  return {
    props: {
      sponsors,
    },
  }; // returns sponsor data
}
export default about;
