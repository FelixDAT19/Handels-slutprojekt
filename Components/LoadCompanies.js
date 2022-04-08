import React from "react";


function LoadCompanies({ id, name, companyInfo, externalUrl, logoUrl, offers, competitions }) {

  
  //site to load in specific comapny and map out its data
  return (
    <div>
      <img src={logoUrl} alt="company logo" className="companyImage"/>
      <h1>{name}</h1>
      <p>
        {companyInfo}
        <br />
        <a href={externalUrl} className="companyLink">{externalUrl}</a>
      </p>
      <h3>Erbjudanden</h3>
      {offers.map(({offer, price}, s) => (
        <div key={s}>
            <p>{offer} {price}</p>
        </div>
      ))}
      {competitions.map(({formUrl}, d) => (
        <div key={d}>
            <a href={formUrl} className="competitionLink">{formUrl}</a>
        </div>
      ))}
    </div>
  );
}

export default LoadCompanies;
