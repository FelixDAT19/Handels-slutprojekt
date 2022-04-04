import React from "react";
import Image from "next/image";

function LoadCompanies({ name, companyInfo, externalUrl, logoUrl }) {
  return (
    <div>
      <image src={logoUrl} alt={logoUrl} />
      <h1>{name}</h1>
      <p>
        {companyInfo}
        <br />
        <a href={externalUrl}>{externalUrl}</a>
      </p>
    </div>
  );
}

export default LoadCompanies;
