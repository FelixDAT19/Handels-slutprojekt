import React from "react";


function LoadCompanies({ id, name, companyInfo, externalUrl, logoUrl, offers, competitions }) {

  
  //site to load in specific comapny and map out its data
  return (
    <div className="companyPage">
      <img src={logoUrl} alt="company logo" className="companyImage"/>
      <div className="companyGeneral">

        <h1 className="companyName">{name}</h1>
        <p className="companyInfo">{companyInfo}</p>

      </div>

      <div className="companyOffer">
        <h3 className="companyOfferName">Erbjudanden</h3>
        {offers.map(({offer, price}, s) => (
          <div key={s} className="offerInformation">
              <div className="offerName">{offer}</div>
              <div className="offerPrice">{price+" €"}</div>
          </div>
        ))}
      </div>
      {competitions.map(({formUrl}, d) => (
        <div key={d} className="competitionLink">
            <a href={formUrl}>Tävling</a>
        </div>
      ))}
    <br/>
    <div className="companyWebsite">

      <a href={externalUrl} className="companyLink">{externalUrl}</a>

    </div>


    </div>
  );
}

export default LoadCompanies;
