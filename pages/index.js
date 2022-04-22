import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import CompanyLinks from "/Components/CompanyLinks";
import prisma from "/api/client";
import CompanyList from "/Components/CompanyList";

function Home({ sponsors, location, compaines }) {
  //start page with links to compaines and thair placements
  
  return (
    <div className="viewport">
      <MainMenu />
      <div className="openHours">
        <h2>Öppettider</h2>
        <p>12-19 1.1.2202</p>
        <p>10-18 1.2.2202</p>
      </div>
      <br/>
      <CompanyList company={compaines}/>
      <br/>
      <img src="/files/lokal.png" className="imageMap" alt="lokalen" useMap="#workmap"/>
        
      <map name="workmap">
        <CompanyLinks location={location}/>
        <area shape="rect" coords="38,1,82,23" alt="cafe" href={`/food`}/>   
        <area shape="rect" coords="105,1,172,23" alt="program" href={`/events`}/>   
      </map>    

      <br/>

      <FooterMenu sponsors={sponsors}/>
    </div>

    
  );
}

export async function getStaticProps() { // fetches sponsors and location data for links
  
  const dataSponsor = await prisma.sponsors.findMany();
  const sponsors = [...JSON.parse(JSON.stringify(dataSponsor)),]

  const dataPlacement = await prisma.placement.findMany({ orderBy: [{id: 'asc'}]}); 
  const location = [...JSON.parse(JSON.stringify(dataPlacement)),]

  const dataCompanies = await prisma.company.findMany({include: {placement: true,},});
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
