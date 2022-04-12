import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import CompanyLinks from "/Components/CompanyLinks";
import prisma from "/api/client";
import CompanyList from "/Components/CompanyList";

function Home({ sponsors, location, compaines }) {
  //start page with links to compaines and thair placements
  
  return (
    <>
      <MainMenu />
      <hr/>
      <div className="openHours">
        <h2>Öppettider</h2>
        <p>12-19</p>
        <p>10-18</p>
      </div>
      <div className="openDate">
        <h2>Datum</h2>
        <p>1.1.2202-1.2.2202</p>
      </div>
      <hr/>
      <img src="/files/lokal.png" className="imageMap" alt="lokalen" useMap="#workmap"/>
        
      <map name="workmap">
        <CompanyLinks location={location}/>
      </map>

      <br/>
      
      <CompanyList company={compaines}/>

      <br/>

      <FooterMenu sponsors={sponsors}/>
    </>

    
  );
}

export async function getStaticProps() { // fetches sponsors and location data for links
  
  const dataSponsor = await prisma.sponsors.findMany();
  const sponsors = [...JSON.parse(JSON.stringify(dataSponsor)),]

  const dataPlacement = await prisma.placement.findMany({ orderBy: [{id: 'asc'}]}); 
  const location = [...JSON.parse(JSON.stringify(dataPlacement)),]

  const dataCompanies = await prisma.company.findMany({include: {placement: { select: { id: true, },},},});
  const compaines = [...JSON.parse(JSON.stringify(dataCompanies)),]


  return {
    props: {
      sponsors,
      location,
      compaines,
    },
  };
}

export default Home;
