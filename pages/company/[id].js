import LoadCompanies from "/Components/LoadCompanies";
import MainMenu from "/Components/MainMenu";
import FooterMenu from "/Components/FooterMenu";
import React from "react";
import prisma from "/api/client";//imports

function company({ placement, sponsors }) {
  return (
    <>
      <MainMenu />

      <LoadCompanies {...placement} />

      <FooterMenu sponsors={sponsors} />
    </>
  );
}
export async function getStaticPaths() { // function to get url information so it can be queryd in the next function
  const data = await prisma.company.findMany({ orderBy: [{ id: "asc" }] }); //query for all data location data
  const companies = [...JSON.parse(JSON.stringify(data))];

  const paths = companies.map((company) => ({ // makes it the url data so it can be used to query
    params: { id: company.id.toString() },
  }));


  return { paths, fallback: false };
}
export async function getStaticProps({ params }) { //function to query after company data
  const data = await prisma.company.findUnique({
    where: { id: parseInt(params.id) },
    include: {offers: true, competitions: true},
    
  });
  const sponsors = await prisma.sponsors.findMany();
  const placement = data;

  return {
    props: {
      placement,
      sponsors: [...JSON.parse(JSON.stringify(sponsors))],
    }, 
  };//returns sponsors and company data from specific placement
}

export default company;
